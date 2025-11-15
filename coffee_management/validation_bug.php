/ * Logic Đăng nhập */
<?php
session_start();
require_once 'db.php'; // Gọi file kết nối

$user = $_POST['user'];
$pass = $_POST['password'];

// 1. TÌM USER TRONG DATABASE (Dùng Prepared Statement)
$s = "SELECT id FROM users WHERE username = ?";
$stmt = mysqli_prepare($con, $s);
mysqli_stmt_bind_param($stmt, 's', $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 2. KIỂM TRA KẾT QUẢ
if ($row = mysqli_fetch_assoc($result)) {
    // Tìm thấy user, TIẾP TỤC KIỂM TRA MẬT KHẨU

    // 3. XÁC THỰC MẬT KHẨU (An toàn)
    if (password_verify($pass, $row['password'])) {
        // Mật khẩu ĐÚNG
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    } else {
        // Mật khẩu SAI
        header('location:login.php?error=invalid');
    }
} else {
    // Không tìm thấy user
    // Đây là logic bạn yêu cầu: "báo tài khoản chưa có"
    header('location:login.php?error=nouser');
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
