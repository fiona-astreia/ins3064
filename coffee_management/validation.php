<?php
session_start();
require_once 'db.php'; // Gọi file kết nối

$user = $_POST['user'];
$pass = $_POST['password'];

// 1. TÌM USER TRONG DATABASE (Dùng Prepared Statement)
// SỬA LỖI 1: Phải SELECT * (hoặc ít nhất là id, username, password)
$s = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($con, $s);
mysqli_stmt_bind_param($stmt, 's', $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 2. KIỂM TRA KẾT QUẢ
if ($row = mysqli_fetch_assoc($result)) {
    // Tìm thấy user, TIẾP TỤC KIỂM TRA MẬT KHẨU

    // 3. XÁC THỰC MẬT KHẨU (An toàn)
    // Bây giờ $row['password'] đã tồn tại vì chúng ta dùng SELECT *
    if (password_verify($pass, $row['password'])) {
        // Mật khẩu ĐÚNG
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];

        // SỬA LỖI 2: Logic dọn dẹp và exit
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header('location:home.php');
        exit(); // <-- THÊM EXIT()

    } else {
        // Mật khẩu SAI
        // SỬA LỖI 2: Logic dọn dẹp và exit
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header('location:login.php?error=invalid');
        exit(); // <-- THÊM EXIT()
    }
} else {
    // Không tìm thấy user
    // SỬA LỖI 2: Logic dọn dẹp và exit
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    header('location:login.php?error=nouser');
    exit(); // <-- THÊM EXIT()
}

// Các lệnh close ở cuối file cũ bây giờ đã được chuyển lên trên
?>