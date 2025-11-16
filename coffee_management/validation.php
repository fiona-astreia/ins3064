<?php
session_start(); // $_SESSION
require_once 'db.php'; // Gọi file kết nối

$user = $_POST['user'];
$pass = $_POST['password'];

// 1. TÌM USER TRONG DATABASE (Prepared Statement _ SQL Injection)
$s = "SELECT * FROM users WHERE username = ?"; // chú ý *
$stmt = mysqli_prepare($con, $s);
mysqli_stmt_bind_param($stmt, 's', $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt); 

// 2. KIỂM TRA KẾT QUẢ
if ($row = mysqli_fetch_assoc($result)) { // ['id'=>3, 'username'=>'chuyi',
    // Tìm thấy user, TIẾP TỤC KIỂM TRA MẬT KHẨU

    // 3. XÁC THỰC MẬT KHẨU (An toàn)
    // Bây giờ $row['password'] đã tồn tại vì chúng ta dùng SELECT *
    if (password_verify($pass, $row['password'])) {
        // Mật khẩu ĐÚNG
        $_SESSION['username'] = $row['username']; // login action
        $_SESSION['user_id'] = $row['id'];

        // SỬA LỖI: Logic dọn dẹp và exit
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header('location:home.php');
        exit(); // <-- THÊM EXIT()

    } else {
        // Mật khẩu SAI
        // SỬA LỖI: Logic dọn dẹp và exit
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header('location:login.php?error=invalid');
        exit(); // <-- THÊM EXIT()
    }
} else {
    // Không tìm thấy user
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    header('location:login.php?error=nouser');
    exit(); 
}

// Các lệnh close ở cuối file cũ bây giờ đã được chuyển lên trên
?>