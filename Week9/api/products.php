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

function getProductId(): int
{
    $value = $_GET['id'] ?? null;

    if (!is_string($value) || !ctype_digit($value)) {
        fail(400, 'Mã sản phẩm không hợp lệ.');
    }

    $id = filter_var(
        $value,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($id === false) {
        fail(400, 'Mã sản phẩm không hợp lệ.');
    }

    return $id;
}

function readProduct(): array
{
    try {
        $data = json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    } catch (JsonException $e) {
        fail(400, 'Dữ liệu gửi lên không hợp lệ.');
    }

    if (!is_array($data)) {
        fail(400, 'Dữ liệu sản phẩm không hợp lệ.');
    }

    $name = $data['name'] ?? null;
    $price = $data['price'] ?? null;
    $stock = $data['stock'] ?? null;

    if (!is_string($name)) {
        fail(422, 'Tên sản phẩm không hợp lệ.');
    }

    $name = trim($name);

    if ($name === '' || mb_strlen($name, 'UTF-8') > 100) {
        fail(422, 'Tên sản phẩm phải có từ 1 đến 100 ký tự.');
    }

    if (
        !is_int($price) ||
        $price < 1 ||
        $price > 2147483647
    ) {
        fail(422, 'Đơn giá phải là số nguyên lớn hơn 0.');
    }

    if (
        !is_int($stock) ||
        $stock < 0 ||
        $stock > 2147483647
    ) {
        fail(422, 'Số lượng tồn phải là số nguyên không âm.');
    }

    return [
        'name' => $name,
        'price' => $price,
        'stock' => $stock
    ];
}

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
        header('Allow: GET, POST, PUT, DELETE');
        fail(405, 'Phương thức không được hỗ trợ.');
    }

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

    if ($method === 'GET') {
        $stmt = $pdo->query(
            'SELECT id, name, price, stock, image
             FROM products
             ORDER BY id DESC'
        );

        respond(200, [
            'success' => true,
            'data' => $stmt->fetchAll()
        ]);
    }

    if ($method === 'POST') {
        $product = readProduct();

        $stmt = $pdo->prepare(
            'INSERT INTO products (name, price, stock)
             VALUES (:name, :price, :stock)'
        );

        $stmt->bindValue(':name', $product['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $product['price'], PDO::PARAM_INT);
        $stmt->bindValue(':stock', $product['stock'], PDO::PARAM_INT);
        $stmt->execute();

        $id = (int) $pdo->lastInsertId();

        respond(201, [
            'success' => true,
            'id' => $id,
            'message' => 'Thêm sản phẩm thành công.'
        ]);
    }

    $id = getProductId();

    $check = $pdo->prepare(
        'SELECT id FROM products WHERE id = :id'
    );
    $check->bindValue(':id', $id, PDO::PARAM_INT);
    $check->execute();

    if (!$check->fetch()) {
        fail(404, 'Không tìm thấy sản phẩm.');
    }

    if ($method === 'PUT') {
        $product = readProduct();

        $stmt = $pdo->prepare(
            'UPDATE products
             SET name = :name,
                 price = :price,
                 stock = :stock
             WHERE id = :id'
        );

        $stmt->bindValue(':name', $product['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $product['price'], PDO::PARAM_INT);
        $stmt->bindValue(':stock', $product['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        respond(200, [
            'success' => true,
            'id' => $id,
            'message' => 'Cập nhật sản phẩm thành công.'
        ]);
    }

    if ($method === 'DELETE') {
        $stmt = $pdo->prepare(
            'DELETE FROM products WHERE id = :id'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        respond(200, [
            'success' => true,
            'message' => 'Xóa sản phẩm thành công.'
        ]);
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    fail(500, 'Không thể xử lý yêu cầu. Vui lòng thử lại sau.');
}
