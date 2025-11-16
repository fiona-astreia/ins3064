/ * Logic Đăng kí */
<?php
session_start();
require_once 'db.php'; // Gọi file kết nối

$user = $_POST['user'];
$pass = $_POST['password'];

// 1. KIỂM TRA USERNAME (Prepared Statement _ SQL Injection)
$s = "SELECT id FROM users WHERE username = ?"; // write
$stmt = mysqli_prepare($con, $s); // chuẩn bị gửi khuôn mẫu cho csdl
mysqli_stmt_bind_param($stmt, 's', $user); // fill (10)
mysqli_stmt_execute($stmt); // call db
mysqli_stmt_store_result($stmt); // return true/false

if (mysqli_stmt_num_rows($stmt) > 0) {
    // Username đã tồn tại

    mysqli_stmt_close($stmt); // Dọn dẹp stmt
    mysqli_close($con);

    header('location:login.php?reg_error=exists');
    exit(); // RẤT QUAN TRỌNG
} else {
    // 2. BĂM MẬT KHẨU (An toàn)
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    // BCRYPT

    // 3. THÊM USER MỚI (Prepared Statement)
    $reg = "INSERT INTO users(username,password) VALUES (?, ?)";
    $stmt_insert = mysqli_prepare($con, $reg);
    mysqli_stmt_bind_param($stmt_insert, 'ss', $user, $hashed_password);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Đăng kí thành công
        mysqli_stmt_close($stmt_insert);
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header("location:login.php?success=true");
        exit(); // QUAN TRỌNG
    } else {
        // Đăng kí thất bại
        mysqli_stmt_close($stmt_insert);
        mysqli_stmt_close($stmt);
        mysqli_close($con);

        header("location:login.php?reg_error=fail");
        exit(); // CHÚ Ý QUAN TRỌNG
    }

}

?>