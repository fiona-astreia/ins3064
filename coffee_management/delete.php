/* XÓA SẢN PHẨM */
<?php
session_start();
require_once 'db.php'; // Gọi file kết nối

// Kiểm tra session
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Chuẩn bị câu truy vấn DELETE
    $query = "DELETE FROM products WHERE id = ?";

    // Sử dụng Prepared Statements để xóa an toàn
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Xóa thành công
        mysqli_stmt_close($stmt); 
        mysqli_close($con);       

        header('location: home.php?msg=deleted');
        exit();
    } else {
        // Xóa thất bại
        mysqli_stmt_close($stmt); 
        mysqli_close($con);       

        header('location: home.php?msg=error');
        exit();
    }
} else {
    // Không có ID hợp lệ
    mysqli_close($con); // Dọn dẹp $con

    header('location: home.php?msg=invalid_id');
    exit();
}
?>