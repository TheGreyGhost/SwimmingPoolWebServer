<?php
// GET_CURRENT_PUMP_STATUS.PHP
    require "db_realtime_connect.php";
    // Get the current pump status

    $sql = "SELECT * FROM PoolHeaterStatusReadable ORDER BY `entry_number` DESC LIMIT 1;";
    $result = mysqli_query($conn_rt, $sql);
    $srow = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn_rt);

    echo (($srow["pump_state"] & 32) != 0 ? "Error" : "OK");
?>
