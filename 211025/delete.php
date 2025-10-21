<?php
include "connection.php";

$id = $_GET["id"]; // Lấy id từ URL
// Không được trùng id
mysqli_query($link, "delete from table1 where id=$id");
// header("location.index.php"); => cú pháp sai

header("Location: index.php");

?>

<script type="text/javascript">
   window.location = "index.php";
</script>