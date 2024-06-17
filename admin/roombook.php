<?php
session_start();
include '../config.php';
$_SESSION['linkSession'] = 'roombook';

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
    <title>BlueBird - Admin</title>
</head>

<body>
    <!-- ================================================= -->
    <div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search..." onkeyup="searchFun()">
        <form action="./exportdata.php" method="post">
            <button class="exportexcel" id="exportexcel" name="exportexcel" type="submit"><i class="fa-solid fa-file-arrow-down"></i></button>
        </form>
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <?php
            $roombooktablesql = "SELECT tblclienti.IdClient, tblClienti.numeClient, tblclienti.emailClient, tblclienti.nrTelClient, tblrezervari.IdRezervare, tblrezervari.statusPlata, tblrezervari.dataCheck_in, tblrezervari.dataCheck_out, tblcamere.IdCamera, tblcamere.tipCamera, (DATEDIFF(dataCheck_out, dataCheck_in)*tblcamere.pretCurentCamera) AS roomPrice, tblservicii.numeServiciu, tblservicii.IdServiciu, tblservicii.pretCurentServiciu FROM tblclienti INNER JOIN tblrezervari ON tblrezervari.IdClientR = tblclienti.IdClient INNER JOIN tblasocieretripla ON tblasocieretripla.IdRezervare_Asoc_tripla = tblrezervari.IdRezervare INNER JOIN tblcamere ON tblasocieretripla.IdCamera_Asoc_tripla = tblcamere.IdCamera INNER JOIN tblservicii ON tblasocieretripla.IdServiciu_Asoc_tripla = tblservicii.IdServiciu 
            WHERE IdClient IS NOT NULL AND IdRezervare IS NOT NULL
            ORDER BY tblClienti.IdClient;";
            $roombookresult = mysqli_query($hotelConn, $roombooktablesql);
            $nums = mysqli_num_rows($roombookresult);
        ?>
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Client Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Type of Room</th>
                    <th scope="col">Service</th>
                    <th scope="col">Check-in</th>
                    <th scope="col">Check-out</th>
                    <th scope="col">Service Price</th>
                    <th scope="col">Room Price</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col" class="action">Action</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>

            <tbody>
            <?php
            while ($res = mysqli_fetch_array($roombookresult)) {
            ?>
                <tr>
                    <td><?php echo $res['IdClient'] ?></td>
                    <td><?php echo $res['numeClient'] ?></td>
                    <td><?php echo $res['emailClient'] ?></td>
                    <td><?php echo $res['nrTelClient'] ?></td>
                    <td><?php echo $res['IdCamera'] ?></td>
                    <td><?php echo $res['tipCamera'] ?></td>
                    <td><?php echo $res['numeServiciu'] ?></td>
                    <td><?php echo $res['dataCheck_in'] ?></td>
                    <td><?php echo $res['dataCheck_out'] ?></td>
                    <td><?php echo $res['pretCurentServiciu'] ?></td>
                    <td><?php echo $res['roomPrice'] ?></td>
                    <td><?php echo $res['statusPlata'] ?></td>
                    <td class="action">
                        <?php
                            if($res['statusPlata'] == "da")
                            {
                                echo " ";
                            }
                            else
                            {
                                echo "<a href='roomconfirm.php?id=". $res['IdRezervare'] ."'><button class='btn btn-success'>Confirm</button></a>";
                            }
                        ?>
                        <?php echo '<a href="roombookedit.php?id='. urlencode($res['IdRezervare']) .'&service='. urlencode($res['IdServiciu']) .'"><button class="btn btn-danger">Edit</button></a>'; ?>
                        <a href="roombookdelete.php?id=<?php echo $res['IdRezervare'] ?>"><button class='btn btn-danger'>Delete Reservation</button></a>
                        <?php echo '<a href="roombookdeleteline.php?id='. urlencode($res['IdRezervare']) .'&service='. urlencode($res['IdServiciu']) .'"><button class="btn btn-danger">Delete Line</button></a>'; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
<script src="./javascript/roombook.js"></script>



</html>