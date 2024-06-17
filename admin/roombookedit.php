<?php

include '../config.php';
session_start();

// fetch room data
$id = $_GET['id'];
$lineService = $_GET['service'];

function updateAsociere_rezervari_camere($id, $cameraId, $hotelConn){
    $sqlAsociereRC = "UPDATE tblasociere_rezervari_camere
    SET IdCamera_ARC = '$cameraId'
    WHERE IdRezervare_ARC = '$id';
    ";
    $result = mysqli_query($hotelConn, $sqlAsociereRC);
}

function updateAsocieretripla($id, $lineService, $cameraId, $serviciuId, $hotelConn){
    $sql = "UPDATE tblasocieretripla
    SET IdCamera_Asoc_tripla = '$cameraId',
    IdServiciu_Asoc_tripla = '$serviciuId'
    WHERE IdRezervare_Asoc_tripla = '$id' AND IdServiciu_Asoc_tripla = '$lineService'
    ";
    $result = mysqli_query($hotelConn, $sql);
}

$sql ="SELECT tblclienti.IdClient, 
tblClienti.numeClient, 
tblclienti.emailClient, 
tblclienti.nrTelClient, 
tblrezervari.IdRezervare, 
tblrezervari.statusPlata, 
tblrezervari.dataCheck_in, 
tblrezervari.dataCheck_out, 
tblcamere.IdCamera, 
tblcamere.tipCamera, 
(DATEDIFF(dataCheck_out, dataCheck_in)*tblcamere.pretCurentCamera) AS roomPrice, 
tblservicii.numeServiciu, 
tblservicii.IdServiciu, 
tblservicii.pretCurentServiciu 
FROM tblclienti 
INNER JOIN tblrezervari ON tblrezervari.IdClientR = tblclienti.IdClient 
INNER JOIN tblasocieretripla ON tblasocieretripla.IdRezervare_Asoc_tripla = tblrezervari.IdRezervare 
INNER JOIN tblcamere ON tblasocieretripla.IdCamera_Asoc_tripla = tblcamere.IdCamera 
INNER JOIN tblservicii ON tblasocieretripla.IdServiciu_Asoc_tripla = tblservicii.IdServiciu 
WHERE tblrezervari.IdRezervare = '$id' AND tblservicii.IdServiciu = '$lineService'";
$re = mysqli_query($hotelConn,$sql);
while($row=mysqli_fetch_array($re))
{
    $Name = $row['numeClient'];
    $Email = $row['emailClient'];
    $Phone = $row['nrTelClient'];
    $cin = $row['dataCheck_in'];
    $cout = $row['dataCheck_out'];
    $RoomType = $row['tipCamera'];
    $Service = $row['numeServiciu'];

    $ClientId = $row['IdClient'];
    $initialRoomId = $row['IdCamera'];
}

if (isset($_POST['guestdetailedit'])) {
    $EditName = $_POST['Name'];
    $EditEmail = $_POST['Email'];
    $EditPhone = $_POST['Phone'];
    $EditRoomType = $_POST['RoomType'];
    $EditService = $_POST['Service'];
    $Editcin = $_POST['cin'];
    $Editcout = $_POST['cout'];

    //Update client
    $sqlClienti = "UPDATE tblclienti
    SET numeClient = '$EditName',
    emailClient = '$EditEmail',
    nrTelClient = '$EditPhone'
    WHERE IdClient = '$ClientId';
    ";
    $result = mysqli_query($hotelConn, $sqlClienti);

    //Update reservation
    $stat = "Se asteapta confirmarea dupa editare";
    $sqlRezervari = "UPDATE tblrezervari
    SET dataCheck_in = '$Editcin',
    dataCheck_out = '$Editcout',
    statusPlata = '$stat'
    WHERE IdRezervare = '$id'
    ";
    $result = mysqli_query($hotelConn, $sqlRezervari);

    //Get roomId & serviceId
    $yes = "da";
    $sqlTblcamere = "SELECT IdCamera FROM tblcamere WHERE (tipCamera = '$EditRoomType' AND disponibilitate = '$yes') LIMIT 1";
    $getIdCamera = mysqli_query($hotelConn, $sqlTblcamere);
    $resIdCamera = mysqli_fetch_assoc($getIdCamera);
    $cameraId = $resIdCamera['IdCamera'];

    $sqlServiciu = "SELECT IdServiciu FROM tblservicii WHERE numeServiciu = '$EditService' LIMIT 1";
    $getIdServiciu = mysqli_query($hotelConn, $sqlServiciu);
    $resServiciu = mysqli_fetch_assoc($getIdServiciu);
    $serviciuId = $resServiciu['IdServiciu'];

    if($EditRoomType != $RoomType){
        if($cameraId){
            updateAsociere_rezervari_camere($id, $cameraId, $hotelConn);
            updateAsocieretripla($id, $lineService, $cameraId, $serviciuId, $hotelConn);
        }
        else{
            echo "<script>swal({
                title: 'No available rooms for type of room selected. Room hasn't been changed',
                icon: 'error',
            });
            </script>";
            updateAsocieretripla($id, $lineService, $initialRoomId, $serviciuId, $hotelConn);

        }
    }
    else{
        updateAsocieretripla($id, $lineService, $initialRoomId, $serviciuId, $hotelConn);
    }

    if($_SESSION['linkSession'] == 'clientReservation'){
        header("Location:../clientreservation.php");
    }
    else{
        header("Location:roombook.php");
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./css/roombook.css">
    <style>
        #editpanel{
            position : fixed;
            z-index: 1000;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            /* align-items: center; */
            background-color: #00000079;
        }
        #editpanel .guestdetailpanelform{
            height: 434px;
            width: 1170px;
            background-color: #ccdff4;
            border-radius: 10px;  
            /* temp */
            position: relative;
            top: 20px;
            animation: guestinfoform .3s ease;
        }

        #editpanel .guestdetailpanelform .middle{
            height: 315px;
        }

    </style>
    <title>Document</title>
</head>
<body>
    <div id="editpanel">
        <form method="POST" action = "" class="guestdetailpanelform">
            <div class="head">
                <h3>EDIT RESERVATION</h3>
                <?php
                if($_SESSION['linkSession'] == 'clientReservation'){
                    echo "<a href='../clientreservation.php'><i class='fa-solid fa-circle-xmark'></i></a>";
                }
                else{
                    echo "<a href='./roombook.php'><i class='fa-solid fa-circle-xmark'></i></a>";
                }
                ?>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name" value="<?php echo $Name ?>">
                    <input type="email" name="Email" placeholder="Enter Email" value="<?php echo $Email ?>">
                    <input type="text" name="Phone" placeholder="Enter Phoneno"  value="<?php echo $Phone ?>">
                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" class="selectinput">
                        <?php echo '<option value ="'.$RoomType.'" selected >'.$RoomType.'</option>'; ?>
                        <option value="Superior Room">Superior Room</option>
                        <option value="Deluxe Room">Deluxe Room</option>
						<option value="Double Room">Double Room</option>
						<option value="Single Room">Single Room</option>
                    </select>

                    <?php
                        $services = array();
                        $sql = "SELECT DISTINCT numeServiciu from tblServicii";
                        $getServices = mysqli_query($hotelConn, $sql);
                        while($res = mysqli_fetch_assoc($getServices)) {
                          $services[] = $res['numeServiciu'];
                        }
                    ?>

                    <select id="Service" name="Service" class="selectinput">
                      <?php echo '<option value ="'.$Service.'" selected >'.$Service.'</option>'; ?>
                      <?php
                        foreach($services as $key => $value):
                        echo '<option value="'.$value.'">'.$value.'</option>';
                        //close your tags!!
                        endforeach;
                      ?>
                    </select>

                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type ="datetime-local" value="<?php echo $cin ?>">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type ="datetime-local" value="<?php echo $cout ?>">
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailedit">Edit</button>
            </div>
        </form>
    </div>
</body>
</html>