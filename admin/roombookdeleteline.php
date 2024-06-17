<?php

include '../config.php';
session_start();

$id = $_GET['id'];
$service = $_GET['service'];

$roomdeletesql = "DELETE FROM tblasocieretripla WHERE IdRezervare_Asoc_tripla = '$id' AND IdServiciu_Asoc_tripla = '$service'";
$result = mysqli_query($hotelConn, $roomdeletesql);

if($_SESSION['linkSession'] == 'clientReservation'){
    header("Location:../clientreservation.php");
}
else{
    header("Location:roombook.php");
}

?>