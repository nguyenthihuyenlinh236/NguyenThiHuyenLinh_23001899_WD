<?php
session_start();

require_once __DIR__ . "/common/dbConnect.php";

$username = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // 1. Kiểm tra dữ liệu không được để trống
    if ($username === "" || trim($password) === "") {
        $error = "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
    } else {
        try {
            // 2. Tìm tài khoản trong database
            $sql = "SELECT id, username, password
                    FROM users
                    WHERE username = :username";

            $stmt = $conn->prepare($sql);
            $stmt->execute(["username" => $username]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 3. Kiểm tra tài khoản và mật khẩu
            if ($user && password_verify($password, $user["password"])) {
                // 4. Lưu thông tin đăng nhập vào session
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                // 5. Chuyển đến danh sách sản phẩm
                header("Location: product_list.php");
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = "Đã xảy ra lỗi. Vui lòng thử lại.";
        }
    }
}
?>

<?php require_once __DIR__ . "/view/header.php"; ?>

<h2>Đăng nhập</h2>

<?php if (isset($_GET["registered"]) && $_GET["registered"] === "1"): ?>
    <p style="color: green;">
        Đăng ký thành công. Vui lòng đăng nhập.
    </p>
<?php endif; ?>

<?php if ($error !== ""): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="login.php">
    <div>
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>">
    </div>

    <br>

    <div>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password">
    </div>

    <br>

    <button type="submit">Đăng nhập</button>
</form>

<p>
    Chưa có tài khoản?
    <a href="register.php">Đăng ký</a>
</p>

<?php require_once __DIR__ . "/view/footer.php"; ?>