<?php
include "db_connect.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Kiểm tra xem username đã tồn tại chưa
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($link, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo ("<p style='color: red;'>Username already exists. Please choose another one.</p>");
    } else {
        // 2. Nếu chưa tồn tại, mã hóa mật khẩu và thêm vào database
        $hashed_password = md5($password);
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if (mysqli_query($link, $insert_query)) {
            echo ("<p style='color: green;'>Registration successful! You can now log in.</p>");
        } else {
            echo ("<p style='color: red;'>Error: " . mysqli_error($link) . "</p>");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h2>
        Register
    </h2>
    <form action="" method="post">
        <label for="username">User name</label>
        <input type="text" name="username" id="username" required> <br><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required> <br><br>

        <input type="submit" name="register" value="Register">
    </form>
    <br>
    <a href="login.php">Already have an account? Login here.</a>
</body>

</html>