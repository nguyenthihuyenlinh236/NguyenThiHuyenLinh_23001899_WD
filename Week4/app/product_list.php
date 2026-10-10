<?php
require_once __DIR__ . "/model/product.php";

// Lấy danh sách sản phẩm từ database
$products = getAllProducts();

// Hiển thị header dùng chung
require_once __DIR__ . "/views/header.php";
?>

<h2>Danh sách sản phẩm</h2>

<p>
    <a href="product_add.php">+ Thêm sản phẩm</a>
</p>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Chức năng</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($products)): ?>
            <tr>
                <td colspan="5">Chưa có sản phẩm nào.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars((string)$product["id"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product["name"]) ?>
                    </td>

                    <td>
                        <?= number_format((float)$product["price"], 0, ",", ".") ?>
                        đ
                    </td>

                    <td>
                        <?= htmlspecialchars((string)$product["quantity"]) ?>
                    </td>

                    <td>
                        <a href="product_edit.php?id=<?= urlencode((string)$product["id"]) ?>">
                            [Sửa]
                        </a>

                        |

                        <a href="product_delete.php?id=<?= urlencode((string)$product["id"]) ?>">
                            [Xóa]
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Hiển thị footer dùng chung
require_once __DIR__ . "/views/footer.php";
?>