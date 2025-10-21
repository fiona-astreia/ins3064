<?php
include "connection.php";
$id = $_GET["id"]; // Lấy id của người dùng cần sửa từ URL

// PHẦN XỬ LÝ KHI NGƯỜI DÙNG NHẤN NÚT "UPDATE" 
if (isset($_POST["update"])) {
    // 1. Lấy dữ liệu mới từ form
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];

    // 2. Cập nhật vào database (Chỉ cần 1 dòng lệnh, dùng biến cho sạch sẽ)
    mysqli_query($link, "update table1 set firstname='$firstname', lastname='$lastname', email='$email', contact='$contact' where id=$id");

    // 3. Chuyển hướng về trang chủ và dừng script
    header("Location: index.php");
    exit;
}



// Lấy thông tin cũ của người dùng để hiển thị sẵn trong form
$res = mysqli_query($link, "select * from table1 where id=$id");
$row = mysqli_fetch_array($res);
?>

<html lang="en">

<head>
    <title>Edit User Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="col-lg-4">
            <h2>Edit User Data</h2>
            <form action="" name="form1" method="post">
                <div class="form-group">
                    <label>First name:</label>
                    <input type="text" class="form-control" name="firstname" value="<?php echo $row["firstname"]; ?>">
                </div>
                <div class="form-group">
                    <label>Last name:</label>
                    <input type="text" class="form-control" name="lastname" value="<?php echo $row["lastname"]; ?>">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row["email"]; ?>">
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo $row["contact"]; ?>">
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>