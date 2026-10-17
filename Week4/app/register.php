<?php
require_once __DIR__ . "/common/dbConnect.php";

$username = "";
$errors = [];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // 1. Kiểm tra dữ liệu không được để trống
    if ($username === "") {
        $errors[] = "Tên đăng nhập không được để trống.";
    }

    if (trim($password) === "") {
        $errors[] = "Mật khẩu không được để trống.";
    }

    if (empty($errors)) {
        try {
            // 2. Kiểm tra tên đăng nhập đã tồn tại chưa
            $sql = "SELECT id FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->execute(["username" => $username]);

            if ($stmt->fetch()) {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            } else {
                // 3. Mã hóa mật khẩu
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // 4. Lưu tài khoản vào database
                $sql = "INSERT INTO users (username, password)
                        VALUES (:username, :password)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    "username" => $username,
                    "password" => $hashedPassword
                ]);

                // 5. Đăng ký thành công, chuyển đến trang đăng nhập
                header("Location: login.php?registered=1");
                exit;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
}
?>

<?php require_once __DIR__ . "/views/header.php"; ?>

<h2>Đăng ký tài khoản</h2>

<?php foreach ($errors as $error): ?>
<p style="color: red;">
    <?= htmlspecialchars($error) ?>
</p>
<?php endforeach; ?>

<form method="POST" action="register.php">
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

    <button type="submit">Đăng ký</button>
</form>

<p>
    Đã có tài khoản?
    <a href="login.php">Đăng nhập</a>
</p>

<?php require_once __DIR__ . "/views/footer.php"; ?>