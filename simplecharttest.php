<?php

function getTimeDiff( $starttime , $endtime  ){

  if(preg_match('/\d{10}/', $starttime) && preg_match('/\d{10}/', $endtime)){
    $h_rtn_time = array();
    $a_days = array();

    $i_datediff = $starttime - $endtime;
    $i_datediff = floor($i_datediff/(60*60*24));
  // check if date gets an negativ value
  if($i_datediff < 0){
    $i_datediff = $i_datediff * -1;
  } 
  $h_rtn_time['days'] = $i_datediff;

  // calc days
  if($i_datediff <= 45){
    while($starttime < $endtime){
      array_push( $a_days, date("d.m.Y", $starttime) );
      $starttime += 86400;
    }
  } else {
    for ($i=0; $i < $i_datediff; $i++) { 
      array_push( $a_days, '' );      
    }
  }
  $h_rtn_time['dates'] = $a_days;

    return $h_rtn_time;  
  } else {
    return FALSE;
  }
  
}
if(isset($_POST['d_startdate']) && isset($_POST['d_enddate'])){
  $i_starttime = strtotime($_POST['d_startdate']);
  $i_endtime = strtotime($_POST['d_enddate']);
} else {
  $i_starttime = strtotime(date("01-m-Y"));
  $i_endtime = time();
}

$a_labels = array();
$a_dataset1 = array();
$i_total = 0;



$h_timediff = getTimeDiff($i_starttime, $i_endtime);

for ($i=0; $i < $h_timediff['days']; $i++) { 
  $i_rand = rand(20,30);
  array_push($a_dataset1, $i_rand);
  $i_total += $i_rand;
}

$s_labels = json_encode($h_timediff['dates']);
$s_dataset1 = json_encode($a_dataset1);

?>


<!DOCTYPE html>

<html>
<meta charset="utf-8">
<head>
    <title> </title>
</head>
<rel="stylesheet" type="text/css" href="css/main.css" />
<link href="/git/simplechart/js/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/git/simplechart/js/jquery-2.1.1.min.js"></script>
<script src="/git/simplechart/js/jquery-ui/jquery-ui.js"></script>
<script src="/git/simplechart/js/Chart.js" type="text/javascript"></script>
<style type="text/css" media="screen">
.canvas-wrapper .chart {
  width: 600;
  height: 300;
}  
</style>
<script type="text/javascript">
$(document).ready(function() {

  // define datepicker
  $("#d_startdate").datepicker();
  $("#d_enddate").datepicker();

  var data = {
    labels : <?php echo $s_labels ?>,
    datasets : [
      {
        label: "Dataset 1",
        fillColor: "rgba(95,95,95,0.3)",
        strokeColor: "rgba(95,95,95,0.2)",
        pointColor: "rgba(95,95,95,0.1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#ddd",
        pointHighlightStroke: "rgba(95,95,95,1)",
        data: <?php echo $s_dataset1 ?>

      }
    ]

  };
  var ctx = $('canvas#goldChart').get(0).getContext("2d");
  var goldChart = new Chart(ctx).Bar(data);
});

</script>

<body>
Simplechart Test
<div style="width:600px; height: 1000px ">
<div id="formdiv">
  <form action="" method="post" accept-charset="utf-8">
    <input id="d_startdate" type="text" name="d_startdate" value="" placeholder="">    
    <input id="d_enddate" type="text" name="d_enddate" value="" placeholder="">    
    <input type="submit" name="submit" value="Anzeigen">
  </form>
</div>

  <div class="canvas-wrapper">
    <canvas id="goldChart" width="600" height="400" class="chart"></canvas>
  </div>
  <div id="total">
  Total: <?php if(isset($i_total)) echo $i_total; ?>
  </div>
</div>


</body>

</html>

