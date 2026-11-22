<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $data): void
{
    http_response_code($status);
    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

function fail(int $status, string $message): void
{
    respond($status, [
        'success' => false,
        'message' => $message
    ]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    fail(405, 'Phương thức không được hỗ trợ.');
}

$rawId = $_POST['product_id'] ?? null;

if (
    !is_string($rawId) ||
    !ctype_digit($rawId)
) {
    fail(400, 'Mã sản phẩm không hợp lệ.');
}

$productId = filter_var(
    $rawId,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

if ($productId === false) {
    fail(400, 'Mã sản phẩm không hợp lệ.');
}

if (
    !isset($_FILES['image']) ||
    !is_array($_FILES['image'])
) {
    fail(400, 'Không tìm thấy file ảnh.');
}

$file = $_FILES['image'];

if (
    !isset(
        $file['name'],
        $file['tmp_name'],
        $file['size'],
        $file['error']
    ) ||
    is_array($file['error']) ||
    is_array($file['tmp_name'])
) {
    fail(400, 'Dữ liệu ảnh không hợp lệ.');
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    if (
        $file['error'] === UPLOAD_ERR_INI_SIZE ||
        $file['error'] === UPLOAD_ERR_FORM_SIZE
    ) {
        fail(413, 'Dung lượng ảnh vượt quá giới hạn cho phép.');
    }

    fail(400, 'Không thể tải ảnh lên. Vui lòng thử lại.');
}

$maxSize = 2 * 1024 * 1024;

if ($file['size'] <= 0 || $file['size'] > $maxSize) {
    fail(422, 'Dung lượng ảnh không được vượt quá 2 MB.');
}

if (!is_uploaded_file($file['tmp_name'])) {
    fail(400, 'File tải lên không hợp lệ.');
}

$extension = strtolower(
    pathinfo($file['name'], PATHINFO_EXTENSION)
);

if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
    fail(422, 'Chỉ hỗ trợ ảnh JPG, JPEG hoặc PNG.');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);

$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png'
];

if (!isset($allowedMimeTypes[$mime])) {
    fail(422, 'Định dạng ảnh không hợp lệ.');
}

$imageInfo = @getimagesize($file['tmp_name']);

if ($imageInfo === false) {
    fail(422, 'File tải lên không phải ảnh hợp lệ.');
}

$imageType = $imageInfo[2];

if (
    !in_array(
        $imageType,
        [IMAGETYPE_JPEG, IMAGETYPE_PNG],
        true
    )
) {
    fail(422, 'Định dạng ảnh không được hỗ trợ.');
}

if (
    ($mime === 'image/jpeg' && $imageType !== IMAGETYPE_JPEG) ||
    ($mime === 'image/png' && $imageType !== IMAGETYPE_PNG)
) {
    fail(422, 'Nội dung ảnh không hợp lệ.');
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=cart;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    $stmt = $pdo->prepare(
        'SELECT id, image
         FROM products
         WHERE id = :id'
    );

    $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch();

    if (!$product) {
        fail(404, 'Không tìm thấy sản phẩm.');
    }

    $uploadDirectory = dirname(__DIR__) . '/uploads';

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0755, true)) {
            fail(500, 'Không thể tạo thư mục lưu ảnh.');
        }
    }

    if (!is_writable($uploadDirectory)) {
        fail(500, 'Không thể ghi dữ liệu vào thư mục ảnh.');
    }

    $fileName = bin2hex(random_bytes(16))
        . '.'
        . $allowedMimeTypes[$mime];

    $destination = $uploadDirectory . '/' . $fileName;
    $imagePath = 'uploads/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        fail(500, 'Không thể lưu ảnh. Vui lòng thử lại.');
    }

    try {
        $stmt = $pdo->prepare(
            'UPDATE products
             SET image = :image
             WHERE id = :id'
        );

        $stmt->bindValue(':image', $imagePath, PDO::PARAM_STR);
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException(
                'Không thể cập nhật đường dẫn ảnh.'
            );
        }
    } catch (Throwable $e) {
        if (is_file($destination)) {
            unlink($destination);
        }

        throw $e;
    }

    respond(200, [
        'success' => true,
        'message' => 'Tải ảnh lên thành công.',
        'image' => $imagePath,
        'product_id' => $productId
    ]);
} catch (Throwable $e) {
    error_log($e->getMessage());

    fail(
        500,
        'Không thể xử lý yêu cầu tải ảnh. Vui lòng thử lại sau.'
    );
}
