<?php
session_start();

// Xóa toàn bộ thông tin phiên đăng nhập
$_SESSION = [];

// Hủy session
session_destroy();

// Chuyển về trang đăng nhập
header("Location: login.php");
exit;
