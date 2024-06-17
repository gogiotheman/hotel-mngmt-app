<?php

include '../config.php';

$id = $_GET['id'];

$roomdeletesql = "DELETE FROM tblsalariati WHERE IdSalariat = $id";

$result = mysqli_query($hotelConn, $roomdeletesql);

header("Location:staff.php");

?>