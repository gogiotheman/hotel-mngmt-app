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
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/room.css">
</head>

<body>
    <div class="addroomsection">
        <form action="" method="POST">
            <label for="troom">Type of Room :</label>
            <select name="troom" class="form-control">
                <option value selected></option>
                <option value="Superior Room">SUPERIOR ROOM</option>
                <option value="Deluxe Room">DELUXE ROOM</option>
                <option value="Double Room">DOUBLE ROOM</option>
                <option value="Single Room">SINGLE ROOM</option>
            </select>

            <label for="Price">Room price :</label><br>
            <input type="number" id="Price" name="Price" value="0.00" class="form-control" min="0">

            <style>
                .addroomsection form input[type=checkbox]{
                    width: 40px;
                }
            </style>

            <div>
                <div>
                  <input type="checkbox" id="Safe" name="Safe">
                  <label for="Safe">Safe</label>
                </div>
                <div>
                  <input type="checkbox" id="AC" name="AC">
                  <label for="AC">AC</label>
                </div>
                <div>
                  <input type="checkbox" id="TV" name="TV">
                  <label for="TV">TV</label>
                </div>
            </div>

            <div>
                <div>
                  <input type="checkbox" id="WiFi" name="WiFi">
                  <label for="WiFi">WiFi</label>
                </div>
                <div>
                  <input type="checkbox" id="minibar" name="minibar">
                  <label for="minibar">Minibar</label>
                </div>
                <div>
                  <input type="checkbox" id="balcony" name="balcony">
                  <label for="balcony">Balcony</label>
                </div>
            </div>

            <button type="submit" class="btn btn-success" name="addroom">Add Room</button>
        </form>

        <?php
        if (isset($_POST['addroom'])) {
            $typeofroom = $_POST['troom'];
            $price = $_POST['Price'];
            $AC = $_POST['AC'];
            $safe = $_POST['Safe'];
            $TV = $_POST['TV'];
            $WiFi = $_POST['WiFi'];
            $minibar = $_POST['minibar'];
            $balcony = $_POST['balcony'];
            $price = $_POST['Price'];
            $yes = 'DA';

            $sql = "INSERT INTO tblcamere(seif, AC, TV, WiFi, minibar, balcon, tipCamera, pretCurentCamera, disponibilitate) 
            VALUES ('$safe', '$AC','$TV', '$WiFi', '$minibar', '$balcony', '$typeofroom', '$price', '$yes')";
            $result = mysqli_query($hotelConn, $sql);

            if ($result) {
                header("Location: room.php");
            }
        }
        ?>
    </div>

    <div class="room">
        <?php
        $sql = "select * from tblcamere";
        $re = mysqli_query($hotelConn, $sql)
        ?>
        <?php
        while ($row = mysqli_fetch_array($re)) {
            $id = $row['tipCamera'];
            if ($id == "Superior Room") {
                echo "<div class='roombox roomboxsuperior'>
						<div class='text-center no-boder'>
                            <i class='fa-solid fa-bed fa-4x mb-2'></i>
							<h3>" . $row['tipCamera'] . "</h3>
                            <div class='mb-1'>" . $row['pretCurentCamera'] . "</div>
                            <a href='roomdelete.php?id=". $row['IdCamera'] ."'><button class='btn btn-danger'>Delete</button></a>
						</div>
                    </div>";
            } else if ($id == "Deluxe Room") {
                echo "<div class='roombox roomboxdelux'>
                        <div class='text-center no-boder'>
                        <i class='fa-solid fa-bed fa-4x mb-2'></i>
                        <h3>" . $row['tipCamera'] . "</h3>
                        <div class='mb-1'>" . $row['pretCurentCamera'] . "</div>
                        <a href='roomdelete.php?id=". $row['IdCamera'] ."'><button class='btn btn-danger'>Delete</button></a>
                    </div>
                    </div>";
            } else if ($id == "Double Room") {
                echo "<div class='roombox roomboguest'>
                <div class='text-center no-boder'>
                <i class='fa-solid fa-bed fa-4x mb-2'></i>
							<h3>" . $row['tipCamera'] . "</h3>
                            <div class='mb-1'>" . $row['pretCurentCamera'] . "</div>
                            <a href='roomdelete.php?id=". $row['IdCamera'] ."'><button class='btn btn-danger'>Delete</button></a>
					</div>
            </div>";
            } else if ($id == "Single Room") {
                echo "<div class='roombox roomboxsingle'>
                        <div class='text-center no-boder'>
                        <i class='fa-solid fa-bed fa-4x mb-2'></i>
                        <h3>" . $row['tipCamera'] . "</h3>
                        <div class='mb-1'>" . $row['pretCurentCamera'] . "</div>
                        <a href='roomdelete.php?id=". $row['IdCamera'] ."'><button class='btn btn-danger'>Delete</button></a>
                    </div>
                    </div>";
            }
        }
        ?>
    </div>

</body>

</html>