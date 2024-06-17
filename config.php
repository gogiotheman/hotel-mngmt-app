<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "bluebirdhotel";
$hotelDatabase = "hoteldb";

$conn = mysqli_connect($server,$username,$password,$database);
$hotelConn = mysqli_connect($server,$username,$password,$hotelDatabase);

if(!$conn || !$hotelConn){
    die("<script>alert('connection Failed.')</script>");
}
// else{
//     echo "<script>alert('connection successfully.')</script>";
// }
?>