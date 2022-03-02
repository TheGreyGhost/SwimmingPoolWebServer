<a href="index.php">Current&nbspreadings</a>&nbsp&nbsp<a href="graphical.php">Historical&nbspGraphs</a>&nbsp&nbspPump&nbspStatus<br>
-------------------------<br>
<?php 
echo "Pool temperature monitor:<br>";
require __DIR__.'/../php/get_current_pump_status.php';
echo "-----------------------<br>";
?>
