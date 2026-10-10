<?php
$host = "localhost";
$dbname = "shopping_cart";
$username = "root";
$password = "";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Bật chế độ báo lỗi bằng exception
    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    die("Kết nối dữ liệu thất bại.");
}
