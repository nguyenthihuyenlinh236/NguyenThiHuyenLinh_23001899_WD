<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function fail(int $status, string $message): void
{
    respond($status, ['success' => false, 'message' => $message]);
}

function productId(): int
{
    $id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 2147483647]
    ]);
    if ($id === false) {
        fail(400, 'ID phải là số nguyên dương hợp lệ trên URL.');
    }
    return $id;
}

function readProduct(): array
{
    try {
        $item = json_decode(file_get_contents('php://input'), false, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        fail(400, 'Nội dung gửi lên không phải JSON hợp lệ.');
    }

    if (!is_object($item)) {
        fail(400, 'Cần gửi một đối tượng JSON gồm name, price và stock.');
    }

    $name = $item->name ?? null;
    if (!is_string($name)) {
        fail(422, 'Tên sản phẩm phải là chuỗi.');
    }
    $name = preg_replace('/^\s+|\s+$/u', '', $name);
    if (!preg_match('/\A.{1,100}\z/us', $name)) {
        fail(422, 'Tên sau khi bỏ khoảng trắng phải có từ 1 đến 100 ký tự.');
    }

    // Giới hạn trên tương ứng với kiểu INT trong database.sql.
    $price = $item->price ?? null;
    $stock = $item->stock ?? null;
    if (!is_int($price) || $price < 1 || $price > 2147483647) {
        fail(422, 'Đơn giá phải là số nguyên từ 1 đến 2147483647.');
    }
    if (!is_int($stock) || $stock < 0 || $stock > 2147483647) {
        fail(422, 'Tồn kho phải là số nguyên từ 0 đến 2147483647.');
    }
    return ['name' => $name, 'price' => $price, 'stock' => $stock];
}

try {
    $method = $_SERVER['REQUEST_METHOD'];
    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
        header('Allow: GET, POST, PUT, DELETE');
        fail(405, 'Phương thức không được hỗ trợ.');
    }
    if ($method === 'PUT' || $method === 'DELETE') {
        $id = productId();
    }
    if ($method === 'POST' || $method === 'PUT') {
        $product = readProduct();
    }

    // Đổi tài khoản và mật khẩu theo cấu hình MySQL của em.
    $pdo = new PDO('mysql:host=localhost;dbname=cart;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        // UPDATE đếm dòng khớp ID, kể cả khi gửi lại dữ liệu cũ.
        PDO::MYSQL_ATTR_FOUND_ROWS => true
    ]);

    switch ($method) {
        case 'GET':
            $stmt = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id');
            respond(200, ['success' => true, 'data' => $stmt->fetchAll()]);

        case 'POST':
            $stmt = $pdo->prepare(
                'INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)'
            );
            $stmt->execute($product);
            respond(201, ['success' => true, 'id' => (int) $pdo->lastInsertId()]);

        case 'PUT':
            $stmt = $pdo->prepare(
                'UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id'
            );
            $product['id'] = $id;
            $stmt->execute($product);
            if ($stmt->rowCount() === 0) {
                fail(404, 'Không tìm thấy sản phẩm.');
            }
            respond(200, ['success' => true, 'message' => 'Đã cập nhật sản phẩm.']);

        case 'DELETE':
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute(['id' => $id]);
            if ($stmt->rowCount() === 0) {
                fail(404, 'Không tìm thấy sản phẩm.');
            }
            respond(200, ['success' => true, 'message' => 'Đã xóa sản phẩm.']);
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    fail(500, 'Không thể xử lý yêu cầu trên máy chủ.');
}
