<?php
include "connection.php";

// Nếu người dùng ấn nút Insert
if (isset($_POST["insert"])) {

    // Lấy dữ liệu từ form

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Chèn vào database 
    mysqli_query($link, "insert into table1(firstname, lastname, email, contact) values('$firstname', '$lastname', '$email', '$contact')");

    // Dùng hướng về trang chính
    header("Location: index.php");
    exit;
}
?>

<html lang="en">

<head>
    <title>User Account Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="col-lg-4">
            <h2>Add New User</h2>
            <form action="" name="form1" method="post">
                <div class="form-group">
                    <label>First name:</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="form-group">
                    <label>Last name:</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <input type="text" class="form-control" name="contact" required>
                </div>
                <button type="submit" name="insert" class="btn btn-success">Insert</button>
            </form>
        </div>

        <div class="col-lg-12">
            <h2>User List</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($link, "select * from table1");
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["firstname"] . "</td>";
                        echo "<td>" . $row["lastname"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["contact"] . "</td>";
                        echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-info'>Edit</a></td>";
                        echo "<td><a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>