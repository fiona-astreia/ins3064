<?php

// Kết nối và chọn Database "loginreg"
$link = mysqli_connect("localhost", "root", "", "loginreg");

// Kiểm tra xem kết nối có thành công không
if ($link === false) {
    // Nếu thất bại, hiển thị lỗi và dừng chương trình
    die("LỖI: Không thể kết nối. " . mysqli_connect_error());
}

?>