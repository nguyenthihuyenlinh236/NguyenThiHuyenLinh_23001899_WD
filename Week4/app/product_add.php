<?php
require_once __DIR__ . "/model/product.php";

$name = "";
$price = "";
$quantity = "";
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");

    // Kiểm tra tên sản phẩm
    if ($name === "") {
        $errors[] = "Tên sản phẩm không được để trống.";
    }

    // Kiểm tra giá
    if ($price === "" || !is_numeric($price) || (float)$price <= 0) {
        $errors[] = "Giá sản phẩm phải lớn hơn 0.";
    }

    // Kiểm tra số lượng
    if (
        $quantity === "" ||
        filter_var($quantity, FILTER_VALIDATE_INT) === false ||
        (int)$quantity < 0
    ) {
        $errors[] = "Số lượng phải là số nguyên lớn hơn hoặc bằng 0.";
    }

    // Chỉ thêm sản phẩm khi dữ liệu hợp lệ
    if (empty($errors)) {
        try {
            $result = addProduct($name, (float)$price, (int)$quantity);

            if ($result) {
                header("Location: product_list.php");
                exit;
            }

            $errors[] = "Không thể thêm sản phẩm.";
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "Đã xảy ra lỗi khi lưu sản phẩm.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
</head>

<body>
    <h2>Thêm sản phẩm</h2>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
        </div>

        <br>

        <div>
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" min="0.01" step="any" value="<?= htmlspecialchars($price) ?>">
        </div>

        <br>

        <div>
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" min="0" step="1"
                value="<?= htmlspecialchars($quantity) ?>">
        </div>

        <br>

        <button type="submit">Thêm sản phẩm</button>
        <a href="product_list.php">Quay lại</a>
    </form>
</body>

</html>