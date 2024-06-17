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
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/room.css">
    <style>
        .roombox{
            background-color: #d1d7ff;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="addroomsection">
        <form action="" method="POST">
            <label for="staffname">Name :</label>
            <input type="text" name="staffname" class="form-control">

            <label for="Service">Department :</label>

            <?php
                $services = array();
                $sql = "SELECT DISTINCT tipDepartament from tbldepartamente";
                $getServices = mysqli_query($hotelConn, $sql);
                while($res = mysqli_fetch_assoc($getServices)) {
                  $services[] = $res['tipDepartament'];
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

            <button type="submit" class="btn btn-success" name="addstaff">Add Employer</button>
        </form>

        <?php
        if (isset($_POST['addstaff'])) {
            $staffname = $_POST['staffname'];
            $staffwork = $_POST['Service'];

            $sql = "SELECT IdDepartament FROM tbldepartamente WHERE tipDepartament = '$staffwork'";
            $result = mysqli_query($hotelConn, $sql);
            $res = mysqli_fetch_assoc($result);
            $departmentId = $res['IdDepartament'];
              
            $sql = "INSERT INTO tblsalariati(numeSalariat, departament) VALUES ('$staffname', '$departmentId')";
            try{
                mysqli_query($hotelConn, $sql);
                header("Location: staff.php");
            }
            catch(Exception $e){
                if($e->getMessage() == "Nu poti adauga salariati in afara de Teodora Ghemu in departamentul de Management"){
                    echo "<script>Swal.fire({
                        title: 'You cannot add other managers beside the current manager: Teodora Ghemu',
                        icon: 'error',
                    });
                    </script>";
                }
                else{
                    echo "<script>Swal.fire({
                        title: 'Something went wrong. Please contact site's owner',
                        icon: 'error',
                    });
                    </script>";
                }
            }
        }
        ?>
    </div>


    <!-- here room add because room.php and staff.php both css is similar -->
    <div class="room">
    <?php
        $sql = "select * from tblsalariati";
        $re = mysqli_query($hotelConn, $sql)
        ?>
        <?php
        while ($row = mysqli_fetch_array($re)) {
            $departId = $row['departament'];
            $sql = "SELECT tipDepartament FROM tbldepartamente WHERE IdDepartament = '$departId'";
            $result = mysqli_query($hotelConn, $sql);
            $res = mysqli_fetch_assoc($result);
            $departmentName = $res['tipDepartament'];

            echo "<div class='roombox'>
					<div class='text-center no-boder'>
                        <i class='fa fa-users fa-5x'></i>
						<h3>" . $row['numeSalariat'] . "</h3>
                        <div class='mb-1'>" . $departmentName . "</div>
                        <a href='staffdelete.php?id=". $row['IdSalariat'] ."'><button class='btn btn-danger'>Delete</button></a>
					</div>
                </div>";
        }
        ?>
    </div>

</body>

</html>