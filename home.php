<?php

include 'config.php';
session_start();

// page redirect
$usermail="";
$usermail=$_SESSION['usermail'];

$sql = "SELECT IdClient FROM tblclienti WHERE emailClient = '$usermail'";
$getId = mysqli_query($hotelConn, $sql);
$res = mysqli_fetch_assoc($getId);
$clientId = $res['IdClient'];
$_SESSION['clientId'] = $clientId;

if($usermail == true){

}else{
  header("location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <title>Hotel blue bird</title>
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- home.js -->
    <script src="./javascript/home.js"></script>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <style>
      #guestdetailpanel{
        display: none;
      }
      #guestdetailpanel .middle{
        height: 450px;
      }
    </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img class="bluebirdlogo" src="./image/bluebirdlogo.png" alt="logo">
      <p>BLUEBIRD</p>
    </div>
    <ul>
      <li><a href="#firstsection">Home</a></li>
      <li><a href="#secondsection">Rooms</a></li>
      <li><a href="#thirdsection">Facilites</a></li>
      <li><a href="#contactus">Contact us</a></li>
      <li><a href="clientreservation.php">See my reservation</a></li>
      <a href="./logout.php"><button class="btn btn-danger">Logout</button></a>
    </ul>
  </nav>

  <section id="firstsection" class="carousel slide carousel_section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="carousel-image" src="./image/hotel1.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel2.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel3.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="./image/hotel4.jpg">
        </div>

        <div class="welcomeline">
          <h1 class="welcometag">Welcome to heaven on earth</h1>
        </div>

      <!-- bookbox -->
      <div id="guestdetailpanel">
        <form id="guestdetailpanelform" action="" method="POST" class="guestdetailpanelform"> <!--method="POST" onsubmit="getReservationDetails()" onsubmit="$('guestdetailpanelform').submit()"-->
            <div class="head">
                <h3>RESERVATION</h3>
                <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
            </div>
            <div class="middle">
              <div class="reservationinfo">
                <h4>Reservation information</h4>
                <select id="RoomType" name="RoomType" class="selectinput" onchange="changeRoomSelectionColor()">
                <option value selected >Type Of Room</option>
                  <option value="Superior Room">SUPERIOR ROOM</option>
                  <option value="Deluxe Room" >DELUXE ROOM</option>
                  <option value="Double Room" >DOUBLE ROOM</option>
                  <option value="Single Room" >SINGLE ROOM</option>
                </select>

                <?php
                  $services = array();
                  $sql = "SELECT DISTINCT numeServiciu from tblServicii";
                  $getServices = mysqli_query($hotelConn, $sql);
                  while($res = mysqli_fetch_assoc($getServices)) {
                    $services[] = $res['numeServiciu'];
                  }
                ?>

                <select id="Service" name="Service" class="selectinput" onchange="addService()">
                  <option value selected >Services To Add Per Day</option>
                  <?php
                    foreach($services as $key => $value):
                    echo '<option value="'.$value.'">'.$value.'</option>';
                    //close your tags!!
                    endforeach;
                  ?>
                </select>

                <div id="servicesList" name="servicesList" class="service-list"></div>
              
                <div class="datesection">
                    <span>
                        <label for="cin"> Check-In</label>
                        <input id = "cin" name="cin" type ="datetime-local">
                    </span>
                    <span>
                        <label for="cin"> Check-Out</label>
                        <input id = "cout" name="cout" type ="datetime-local">
                    </span>
                </div>
              </div>
            </div>
            <div class="footer">
                <button type="submit" id="submitButton" class="btn btn-success" name="guestdetailsubmit">Submit</button> <!--onclick="getReservationDetails()" -->
            </div>
          </form>

          <!-- ==== room book php ====-->
          <?php
              if(isset($_POST['guestdetailsubmit']) || isset($_POST['roomType'])){   //
                $RoomType = $_POST['roomType'];
                $cin = $_POST['checkIn'];
                $cout = $_POST['checkOut'];

                $jsArrayJson = $_POST['serviceArray'];
                $servicesArray = json_decode($jsArrayJson);

                if($RoomType == "" || $cin == "" || $cout == ""){
                  $response = array(
                    'status' => 'error',
                    'message' => 'Fill the proper details',
                  ); 
                  echo '<div id="phpResponse">';
                  echo json_encode($response);
                  echo '</div>';
                  }
                else{
                  $yes = 'DA';

                  $sqlTblcamere = "SELECT IdCamera FROM tblcamere WHERE (tipCamera = '$RoomType' AND disponibilitate = '$yes') LIMIT 1";
                  $getIdCamera = mysqli_query($hotelConn, $sqlTblcamere);
                  $resIdCamera = mysqli_fetch_assoc($getIdCamera);
                  $cameraId = $resIdCamera['IdCamera'];
                  if($cameraId){
                    $sqlInsertRezervare = "INSERT INTO tblrezervari (IdClientR, dataCheck_in, dataCheck_out) VALUES ('$clientId', '$cin', '$cout');";
                    try{
                      $setRezervareRecord = mysqli_query($hotelConn, $sqlInsertRezervare);
                    }
                    catch(Exception $e){
                      if($e->getMessage() == "Exista deja o rezervare care se suprapune cu aceasta perioada."){
                        $response = array(
                          'status' => 'error',
                          'message' => 'All rooms of this type are reserved for selected period',
                        ); 
                        echo '<div id="phpResponse">';
                        echo json_encode($response);
                        echo '</div>';
                      }
                    }
    
                    $rezervareId = getRezervareId($hotelConn);
                    setAsociere_rezervari_camere($rezervareId, $cameraId, $hotelConn);
                            
                    if(setAsociereTripla($rezervareId, $cameraId, $servicesArray, $hotelConn)){
                      $response = array(
                        'status' => 'success',
                        'message' => 'Reservation successful',
                      ); 
                      echo '<div id="phpResponse">';
                      echo json_encode($response);
                      echo '</div>';
                    }
                    else{
                      $response = array(
                        'status' => 'error',
                        'message' => "Something went wrong. Contact site's owner",
                      ); 
                      echo '<div id="phpResponse">';
                      echo json_encode($response);
                      echo '</div>';
                    }
                  }
                  else{
                  $response = array(
                    'status' => 'error',
                    'message' => 'No Available Room for selected type of room and dates.',
                  ); 
                  echo '<div id="phpResponse">';
                  echo json_encode($response);
                  echo '</div>';
                  }
                }

              }
           ?>
        
        <?php
          function getRezervareId($Conn){
            $sqlGetIdRezervare = "SELECT IdRezervare from tblrezervari ORDER BY IdRezervare DESC LIMIT 1";
            $getIdRezervare = mysqli_query($Conn, $sqlGetIdRezervare);
            $resIdRezervare = mysqli_fetch_assoc($getIdRezervare);
            $rezervareId = $resIdRezervare['IdRezervare'];
            return $rezervareId;
          }

          function setAsociere_rezervari_camere($IdRezervare, $IdCamera, $Conn){
            $sqlSetAsociere = "INSERT INTO tblasociere_rezervari_camere (IdRezervare_ARC, IdCamera_ARC) VALUES ('$IdRezervare', '$IdCamera')";
            try{
              $setAsociere = mysqli_query($Conn, $sqlSetAsociere);
            }
            catch(Exception $e){
              echo 'Message: ', $e->getMessage();
            }
          }

          function setAsociereTripla($IdRezervare, $IdCamera, $Services, $Conn){
            foreach($Services as $key => $value):
              $sqlGetIdServiciu = "SELECT IdServiciu FROM tblservicii WHERE numeServiciu = '$value' LIMIT 1";
              $getIdServiciu = mysqli_query($Conn, $sqlGetIdServiciu);
              if($getIdServiciu){
                $resIdServiciu = mysqli_fetch_assoc($getIdServiciu);
                $serviciuId = $resIdServiciu['IdServiciu'];

                $sqlSetAsociereTripla = "INSERT INTO tblasocieretripla (IdRezervare_Asoc_tripla, IdCamera_Asoc_tripla, IdServiciu_Asoc_tripla) VALUES ('$IdRezervare', '$IdCamera', '$serviciuId')";
                $setAsociereTripla = mysqli_query($Conn, $sqlSetAsociereTripla); 
                if(!$setAsociereTripla){
                  return false;
                }
              }
            endforeach;
            return true;
          }
        ?>
      </div>
    </div>
  </section>
    
  <section id="secondsection"> 
    <img src="./image/homeanimatebg.svg">
    <div class="ourroom">
      <h1 class="head">≼ Our rooms ≽</h1>
      <div class="roomselect">
        <div class="roombox">
          <div class="hotelphoto h1"></div>
          <div class="roomdata">
            <h2>Superior Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-tv"></i>
              <i class="fa-solid fa-temperature-arrow-up"></i>
              <i class="fa-solid fa-wind"></i>
              <i class="fa-solid fa-wine-bottle"></i>
              <i class="fa-solid fa-lock"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h2"></div>
          <div class="roomdata">
            <h2>Delux Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-tv"></i>
              <i class="fa-solid fa-temperature-arrow-up"></i>
              <i class="fa-solid fa-wind"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h3"></div>
          <div class="roomdata">
            <h2>Double Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-tv"></i>
              <i class="fa-solid fa-temperature-arrow-up"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h4"></div>
          <div class="roomdata">
            <h2>Single Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-tv"></i>
              <i class="fa-solid fa-temperature-arrow-up"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="thirdsection">
    <h1 class="head">≼ Facilities ≽</h1>
    <div class="facility">
      <div class="box">
        <h2>Swiming pool</h2>
      </div>
      <div class="box">
        <h2>Spa</h2>
      </div>
      <div class="box">
        <h2>Restaurant</h2>
      </div>
      <div class="box">
        <h2>Gym</h2>
      </div>
      <div class="box">
        <h2>Tennis court</h2>
      </div>
    </div>
  </section>
  

  <section id="contactus">
    <div class="social">
      <i class="fa-brands fa-instagram"></i>
      <i class="fa-brands fa-facebook"></i>
      <i class="fa-solid fa-envelope"></i>
    </div>
    <div class="createdby">
      <h5>Created by @gogiotheman</h5>
    </div>
  </section>
</body>

<script>

    var bookbox = document.getElementById("guestdetailpanel");

    openbookbox = () =>{
      bookbox.style.display = "flex";
    }
    closebox = () =>{
      bookbox.style.display = "none";
    }
</script>
</html>