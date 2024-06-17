<?php

include '../config.php';

$id = $_GET['id'];

$roomdeletesql = "DELETE FROM tblcamere WHERE IdCamera = '$id'";
$result = mysqli_query($hotelConn, $roomdeletesql);

header("Location:room.php");
?>