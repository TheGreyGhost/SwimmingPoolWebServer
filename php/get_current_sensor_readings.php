<?php
// GET_CURRENT_SENSOR_READINGS.PHP
    require "db_realtime_connect.php";
    // Get the latest sensor reading, round the result for each sensor and update webpage
    $sql = "SELECT * FROM PoolHeaterSensorValues ORDER BY `entry_number` DESC LIMIT 1 ";
    $result = mysqli_query($conn_rt, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "current water temperature (only valid if pump running):".round($row["hx_cold_inlet_smooth"],1)." C<br>";
    echo "current air temperature:".round($row["temp_ambient_smooth"],1)." C<br>";
    mysqli_free_result($result);
    mysqli_close($conn_rt);
?>
