<?php
// GET_CURRENT_SENSOR_READINGS.PHP
    require "db_realtime_connect.php";
    // Get the latest sensor reading, round the result for each sensor and update webpage
    $sql = "SELECT * FROM PoolHeaterSensorValues ORDER BY `entry_number` DESC LIMIT 1 ";
    $result = mysqli_query($conn_rt, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "current water temperature (only valid if pump running):".round($row["hx_cold_inlet_smooth"],1)." C<br>";
    echo "current air temperature:".round($row["temp_ambient_smooth"],1)." C<br>";
    $unix_timestamp = $row["timestamp"];
    $datetime = new DateTime("@$unix_timestamp");

	// convert from UTC (GMT) to local time
    $date_time_format = $datetime->format('Y-m-d H:i:s');
    $time_zone_from="UTC";
    $time_zone_to='Australia/Adelaide';
    $display_date = new DateTime($date_time_format, new DateTimeZone($time_zone_from));
    $display_date->setTimezone(new DateTimeZone($time_zone_to));
    echo "measured at ".$display_date->format('d-m-Y H:i:s')."<br>";   
    
    mysqli_free_result($result);
    mysqli_close($conn_rt);
?>
