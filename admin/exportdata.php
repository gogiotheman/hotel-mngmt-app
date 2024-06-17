<?php

include '../config.php';

$sqlq = "SELECT tblclienti.IdClient, tblClienti.numeClient, tblclienti.emailClient, tblclienti.nrTelClient, tblrezervari.IdRezervare, tblrezervari.statusPlata, tblrezervari.dataCheck_in, tblrezervari.dataCheck_out, tblcamere.IdCamera, tblcamere.tipCamera, (DATEDIFF(dataCheck_out, dataCheck_in)*tblcamere.pretCurentCamera) AS roomPrice, tblservicii.numeServiciu, tblservicii.pretCurentServiciu FROM tblclienti INNER JOIN tblrezervari ON tblrezervari.IdClientR = tblclienti.IdClient INNER JOIN tblasocieretripla ON tblasocieretripla.IdRezervare_Asoc_tripla = tblrezervari.IdRezervare INNER JOIN tblcamere ON tblasocieretripla.IdCamera_Asoc_tripla = tblcamere.IdCamera INNER JOIN tblservicii ON tblasocieretripla.IdServiciu_Asoc_tripla = tblservicii.IdServiciu 
WHERE IdClient IS NOT NULL AND IdRezervare IS NOT NULL
ORDER BY tblClienti.IdClient;";
$result = mysqli_query($hotelConn,$sqlq);
$roombook_record = array();

while( $rows = mysqli_fetch_assoc($result)){
    $roombook_record[] = $rows;
}

if(isset($_POST["exportexcel"]))
{
    $filename = "bluebird_roombook_data_".date('Ymd') .".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $show_coloumn = false;
    if(!empty($roombook_record)){
        foreach($roombook_record as $record){
            if(!$show_coloumn){
                echo implode("\t",array_keys($record)) . "\n";
                $show_coloumn = true;
            }
            echo implode("\t", array_values($record)) . "\n";
        }
    }
    exit;
}


?>