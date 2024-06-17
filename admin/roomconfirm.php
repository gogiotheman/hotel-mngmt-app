<?php

include '../config.php';

$id = $_GET['id'];
$servicePrice = 0;
$serviceCount = 0;

$sql ="SELECT (DATEDIFF(dataCheck_out, dataCheck_in)*tblcamere.pretCurentCamera) AS roomPrice, tblservicii.pretCurentServiciu FROM tblclienti INNER JOIN tblrezervari ON tblrezervari.IdClientR = tblclienti.IdClient INNER JOIN tblasocieretripla ON tblasocieretripla.IdRezervare_Asoc_tripla = tblrezervari.IdRezervare INNER JOIN tblcamere ON tblasocieretripla.IdCamera_Asoc_tripla = tblcamere.IdCamera INNER JOIN tblservicii ON tblasocieretripla.IdServiciu_Asoc_tripla = tblservicii.IdServiciu 
WHERE IdRezervare = '$id'";
$re = mysqli_query($hotelConn,$sql);
while($row=mysqli_fetch_array($re))
{
	$roomPrice = $row['roomPrice'];
    $servicePrice = $servicePrice + $row['pretCurentServiciu'];
    $serviceCount = $serviceCount + 1;
}

$totalPrice = $servicePrice + $roomPrice;

$st = "da";
$sql = "UPDATE tblrezervari SET statusPlata = '$st', pretTotal = '$totalPrice', pretTotalServicii = '$servicePrice', nrTotalServicii = '$serviceCount' WHERE IdRezervare = '$id'";
$result = mysqli_query($hotelConn,$sql);
header("Location:roombook.php");
    
?>