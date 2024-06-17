<?php
    session_start();
    include '../config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<!-- css for table and search bar -->
	<link rel="stylesheet" href="css/roombook.css">

</head>
<body>
	<div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search..." onkeyup="searchFun()">
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <?php
            $paymanttablesql = "SELECT * FROM tblrezervari JOIN tblclienti ON tblclienti.IdClient = tblrezervari.IdClientR 
            JOIN tblasociere_rezervari_camere ON tblrezervari.IdRezervare = tblasociere_rezervari_camere.IdRezervare_ARC
            JOIN tblcamere ON tblcamere.IdCamera = tblasociere_rezervari_camere.IdCamera_ARC
            WHERE statusPlata IS NOT NULL";
            $paymantresult = mysqli_query($hotelConn, $paymanttablesql);

            $nums = mysqli_num_rows($paymantresult);
        ?>
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Reservation Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">No of Services Included</th>
                    <th scope="col">Room Rent</th>
                    <th scope="col">Services Total</th>
					<th scope="col">Total Bill</th>
                    <th scope="col">Action</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>

            <tbody>
            <?php
            while ($res = mysqli_fetch_array($paymantresult)) {
            ?>
                <tr>
                    <td><?php echo $res['IdRezervare'] ?></td>
                    <td><?php echo $res['numeClient'] ?></td>
                    <td><?php echo $res['tipCamera'] ?></td>
                    <td><?php echo $res['dataCheck_in'] ?></td>
                    <td><?php echo $res['dataCheck_out'] ?></td>
					<td><?php echo $res['nrTotalServicii'] ?></td>
                    <td><?php echo $res['pretCurentCamera'] ?></td>
					<td><?php echo $res['pretTotalServicii'] ?></td>
                    <td><?php echo $res['pretTotal'] ?></td>
                    <td class="action">
                        <?php echo '<a href="invoiceprint.php?id='. urlencode($res['IdRezervare']) .'&room='. urlencode($res['IdCamera']) .'"><button class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button></a>'; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    //search bar logic using js
    const searchFun = () =>{
        let filter = document.getElementById('search_bar').value.toUpperCase();

        let myTable = document.getElementById("table-data");

        let tr = myTable.getElementsByTagName('tr');

        for(var i = 0; i< tr.length;i++){
            let td = tr[i].getElementsByTagName('td')[1];

            if(td){
                let textvalue = td.textContent || td.innerHTML;

                if(textvalue.toUpperCase().indexOf(filter) > -1){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }
        }

    }

</script>

</html>