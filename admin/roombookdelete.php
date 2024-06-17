<?php

include '../config.php';
session_start();

$id = $_GET['id'];

$roomdeletesql = "DELETE FROM tblrezervari WHERE IdRezervare = '$id'";
$result = mysqli_query($hotelConn, $roomdeletesql);

$roomdeletesql = "DELETE FROM tblasociere_rezervari_camere WHERE IdRezervare_ARC = '$id'";
$result = mysqli_query($hotelConn, $roomdeletesql);

$roomdeletesql = "DELETE FROM tblasocieretripla WHERE IdRezervare_Asoc_tripla = '$id'";
$result = mysqli_query($hotelConn, $roomdeletesql);

if($_SESSION['linkSession'] == 'clientReservation'){
    header("Location:../clientreservation.php");
}
else{
    header("Location:roombook.php");
}

?>