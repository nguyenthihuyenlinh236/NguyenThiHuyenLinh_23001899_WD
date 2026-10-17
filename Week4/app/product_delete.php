<?php
require_once __DIR__ . "/common/auth.php";
require_once __DIR__ . "/model/product.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
}

if ($id === false || $id === null || $id <= 0) {
    die("ID sản phẩm không hợp lệ.");
}

// Kiểm tra sản phẩm có tồn tại không
$product = getProductById($id);

if ($product === false) {
    die("Sản phẩm không tồn tại hoặc đã bị xóa.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $result = deleteProduct($id);

        if ($result) {
            header("Location: product_list.php");
            exit;
        }

        $error = "Không thể xóa sản phẩm.";
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $error = "Đã xảy ra lỗi khi xóa sản phẩm.";
    }
}
require_once __DIR__ . "/views/header.php";
?>
<h2>Xóa sản phẩm</h2>

<?php if ($error !== ""): ?>
<p style="color: red;">
    <?= htmlspecialchars($error) ?>
</p>
<?php endif; ?>

<p>
    Em có chắc chắn muốn xóa sản phẩm
    <strong><?= htmlspecialchars($product["name"]) ?></strong>
    không?
</p>

<p>
    ID: <?= htmlspecialchars((string)$product["id"]) ?><br>
    Giá: <?= number_format((float)$product["price"], 0, ',', '.') ?> đ<br>
    Số lượng: <?= htmlspecialchars((string)$product["quantity"]) ?>
</p>

<form action="product_delete.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$product["id"]) ?>">

    <button type="submit">Xác nhận xóa</button>
    <a href="product_list.php">Hủy</a>
</form>
<?php
// Hiển thị footer dùng chung
require_once __DIR__ . "/views/footer.php";
?>