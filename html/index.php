Current&nbspreadings&nbsp&nbsp<a href="graphical.php">Historical&nbspGraphs</a>&nbsp&nbsp<a href="pumpstatus.php">Pump&nbspStatus</a><br>
-------------------------<br>
<?php 
echo "Pool temperature monitor:<br>";
require __DIR__.'/../php/get_current_sensor_readings.php';
echo "-----------------------<br>";
?>
