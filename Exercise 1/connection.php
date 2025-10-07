<?php
//creating a database connection - $link is a variable use for just connection class
$link=mysqli_connect("localhost","root","") or die(mysqli_error($link));
mysqli_select_db($link,"LaptopShopDB") or die(mysqli_error($link));

