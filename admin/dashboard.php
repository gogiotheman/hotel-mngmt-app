<?php
    session_start();
    include '../config.php';

    // roombook
    $no = "NU";
    $roombooksql ="Select * from tblcamere WHERE disponibilitate = '$no'";
    $roombookre = mysqli_query($hotelConn, $roombooksql);
    $roombookrow = mysqli_num_rows($roombookre);

    // staff
    $staffsql ="Select * from tblsalariati";
    $staffre = mysqli_query($hotelConn, $staffsql);
    $staffrow = mysqli_num_rows($staffre);

    // room
    $roomsql ="Select * from tblcamere";
    $roomre = mysqli_query($hotelConn, $roomsql);
    $roomrow = mysqli_num_rows($roomre);

    //roombook roomtype
    $chartroom1 = "SELECT * FROM tblcamere WHERE tipCamera='Superior Room' AND disponibilitate='NU'";
    $chartroom1re = mysqli_query($hotelConn, $chartroom1);
    $chartroom1row = mysqli_num_rows($chartroom1re);

    $chartroom2 = "SELECT * FROM tblcamere WHERE tipCamera='Deluxe Room' AND disponibilitate='NU'";
    $chartroom2re = mysqli_query($hotelConn, $chartroom2);
    $chartroom2row = mysqli_num_rows($chartroom2re);

    $chartroom3 = "SELECT * FROM tblcamere WHERE tipCamera='Double Room' AND disponibilitate='NU'";
    $chartroom3re = mysqli_query($hotelConn, $chartroom3);
    $chartroom3row = mysqli_num_rows($chartroom3re);

    $chartroom4 = "SELECT * FROM tblcamere WHERE tipCamera='Single Room' AND disponibilitate='NU'";
    $chartroom4re = mysqli_query($hotelConn, $chartroom4);
    $chartroom4row = mysqli_num_rows($chartroom4re);
?>
<!-- moriss profit -->
<?php 	
					$chart_data = '';
					$totQ1 = 0;
					$totQ2 = 0;
					$totQ3 = 0;
					$totQ4 = 0;
          $tot = 0;
          $dq1 = mktime(0, 0, 0, 3, 15, 2024);
          $dq2 = mktime(0, 0, 0, 6, 15, 2024);
          $dq3 = mktime(0, 0, 0, 9, 15, 2024);
          $dq4 = mktime(0, 0, 0, 12, 15, 2024);
          $query = "SELECT dataCheck_out, pretTotal FROM tblrezervari WHERE statusPlata IS NOT NULL";
					$result = mysqli_query($hotelConn, $query);
					while($row = mysqli_fetch_array($result))
					{
              /*$chart_data .= "{ date:'".$row["cout"]."', profit:".$row["finaltotal"]*10/100 ."}, ";
              $tot = $tot + $row["finaltotal"]*10/100;*/
              if(strtotime($row['dataCheck_out']) < $dq1){
                $totQ1 = $totQ1 + $row['pretTotal'];
              }
              elseif(strtotime($row['dataCheck_out']) < $dq2){
                $totQ2 = $totQ2 + $row['pretTotal'];
              }
              elseif(strtotime($row['dataCheck_out']) < $dq3){
                $totQ3 = $totQ3 + $row['pretTotal'];
              }
              elseif(strtotime($row['dataCheck_out']) < $dq4){
                $totQ4 = $totQ4 + $row['pretTotal'];
              }
              $tot = $tot + $row['pretTotal'];
					}

          $chart_data .= "{ date:'1st quarter', profit:".$totQ1 ."}, ";
          $chart_data .= "{ date:'2nd quarter', profit:".$totQ2 ."}, ";
          $chart_data .= "{ date:'3rd quarter', profit:".$totQ3 ."}, ";
          $chart_data .= "{ date:'4th quarter', profit:".$totQ4 ."}, ";

					$chart_data = substr($chart_data, 0, -2);
				
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dashboard.css">
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- morish bar -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <title>BlueBird - Admin </title>
</head>
<body>
   <div class="databox">
        <div class="box roombookbox">
          <h2>Total Booked Room</h1>  
          <h1><?php echo $roombookrow ?> / <?php echo $roomrow ?></h1>
        </div>
        <div class="box guestbox">
        <h2>Total Staff</h1>  
          <h1><?php echo $staffrow ?></h1>
        </div>
        <div class="box profitbox">
        <h2>Profit</h1>  
          <h1><?php echo $tot?> <span>RON</span></h1>
        </div>
    </div>
    <div class="chartbox">
        <div class="bookroomchart">
            <canvas id="bookroomchart"></canvas>
            <h3 style="text-align: center;margin:10px 0;">Booked Room</h3>
        </div>
        <div class="profitchart" >
            <div id="profitchart"></div>
            <h3 style="text-align: center;margin:10px 0;">Profit</h3>
        </div>
    </div>
</body>



<script>
        const labels = [
          'Superior Room',
          'Deluxe Room',
          'Double Room',
          'Single Room',
        ];
      
        const data = {
          labels: labels,
          datasets: [{
            label: 'My First dataset',
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderColor: 'black',
            data: [<?php echo $chartroom1row ?>,<?php echo $chartroom2row ?>,<?php echo $chartroom3row ?>,<?php echo $chartroom4row ?>],
          }]
        };
  
        const doughnutchart = {
          type: 'doughnut',
          data: data,
          options: {}
        };
        
      const myChart = new Chart(
      document.getElementById('bookroomchart'),
      doughnutchart);
</script>

<script>
Morris.Bar({
 element : 'profitchart',
 data:[<?php echo $chart_data;?>],
 xkey:'date',
 ykeys:['profit'],
 labels:['Profit'],
 hideHover:'auto',
 stacked:true,
 barColors:[
  'rgba(153, 102, 255, 1)',
 ]
});
</script>

</html>