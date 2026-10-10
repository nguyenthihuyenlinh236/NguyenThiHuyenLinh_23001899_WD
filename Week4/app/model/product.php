<?php
require_once __DIR__ . "/../common/dbConnect.php";

// Lấy tất cả sản phẩm
function getAllProducts()
{
    global $conn;

    $sql = "SELECT * FROM products";
    $stmt = $conn->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy sản phẩm theo ID
function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["id" => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Thêm sản phẩm
function addProduct($name, $price, $quantity)
{
    global $conn;

    $sql = "INSERT INTO products (name, price, quantity)
            VALUES (:name, :price, :quantity)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        "name" => $name,
        "price" => $price,
        "quantity" => $quantity
    ]);
}

// Cập nhật sản phẩm
function updateProduct($id, $name, $price, $quantity)
{
    global $conn;

    $sql = "UPDATE products
            SET name = :name,
                price = :price,
                quantity = :quantity
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        "id" => $id,
        "name" => $name,
        "price" => $price,
        "quantity" => $quantity
    ]);
}

// Xóa sản phẩm
function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);

    return $stmt->execute(["id" => $id]);
}
