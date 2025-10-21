<?php
session_start();
// header("location:login.php"); 

/* connect to database check user*/
$con = mysqli_connect('localhost', 'root');
mysqli_select_db($con, 'loginreg');

/* create variables to store data */
$name = $_POST['user'];
$pass = $_POST['password'];
$student_id = $_POST['student_id'];
$dob = $_POST['dob'];
$country = $_POST['country'];

/* select data from DB */
$s = "select * from userreg where name='$name'";

/* result variable to store data */
$result = mysqli_query($con, $s);

/* check for duplicate names and count records */
$num = mysqli_num_rows($result);

if ($num == 1) {
    echo "Username Exists";
} else {
    $reg = "INSERT INTO userreg(name, password, studentID, dateOfBirth, country) 
            VALUES ('$name', '$pass', '$student_id', '$dob', '$country')";
    mysqli_query($con, $reg);
    echo "registration successful";
    header("location:login.php");
}
?>