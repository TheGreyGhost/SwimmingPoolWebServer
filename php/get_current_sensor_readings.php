<?php
// GET_CURRENT_SENSOR_READINGS.PHP
    require "db_realtime_connect.php";
    // Get the latest sensor reading, round the result for each sensor and update webpage
    $sql = "SELECT * FROM PoolHeaterSensorValues ORDER BY `entry_number` DESC LIMIT 1;";
    $result = mysqli_query($conn_rt, $sql);
    $vrow = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $sql = "SELECT * FROM PoolHeaterStatusReadable ORDER BY `entry_number` DESC LIMIT 1;";
    $result = mysqli_query($conn_rt, $sql);
    $srow = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn_rt);

    $unix_timestamp = $vrow["timestamp"];
    $datetime = new DateTime("@$unix_timestamp");
	// convert from UTC (GMT) to local time
    $date_time_format = $datetime->format('Y-m-d H:i:s');
    $time_zone_from="UTC";
    $time_zone_to='Australia/Adelaide';
    $display_date = new DateTime($date_time_format, new DateTimeZone($time_zone_from));
    $display_date->setTimezone(new DateTimeZone($time_zone_to));
    echo "last info update:".$display_date->format('H:i:s D j M Y')."<br>";   
    if ($vrow["last_sampled_temperature_valid"]) {
      $unix_timestamp = $vrow["last_sampled_temperature_time"];
      $datetime = new DateTime("@$unix_timestamp");
	  // convert from UTC (GMT) to local time
      $date_time_format = $datetime->format('Y-m-d H:i:s');
      $time_zone_from="UTC";
      $time_zone_to='Australia/Adelaide';
      $display_date = new DateTime($date_time_format, new DateTimeZone($time_zone_from));
      $display_date->setTimezone(new DateTimeZone($time_zone_to));
      echo "pool temperature:".round($vrow["last_sampled_temperature"],1)." C measured at ".$display_date->format('H:i:s D j M Y')."<br>";
    } else {
      echo "pool temperature: MEASUREMENT NOT CURRENTLY AVAILABLE<br>";
    }
    echo "current air temperature:".round($vrow["temp_ambient_smooth"],1)." C<br>";
    echo "current pump status:".$srow["pump_state_label"]."[".$srow["pump_state"]."]<br>";
    echo "----------------<br>";	
    echo "sunshine brightness:".round($vrow["solar_intensity"],0)."%<br>";
    echo "surge tank level:".($vrow["surge_tank_ok"] ? "OK" : "LOW")."<br>";
    echo "pump runtime since midnight:".round($vrow["pump_runtime"]/3600,3)." hours<br>";
    echo "sunshine since midnight:".round($vrow["cumulative_insolation"]/3600,1)." %.hours<br>";
    echo "heat exchanger temperatures:<br>";
    echo "hot inlet (from tank):".round($vrow["hx_hot_inlet_smooth"],1)." C<br>";
    echo "hot outlet (to roof):".round($vrow["hx_hot_outlet_smooth"],1)." C<br>";
    echo "cold inlet (from pool):".round($vrow["hx_cold_inlet_smooth"],1)." C<br>";
    echo "cold outlet (to pool):".round($vrow["hx_cold_outlet_smooth"],1)." C<br>";
    echo "--system status---<br>";	
    echo "logfile status:".$srow["logfile_status_label"]."<br>";
    echo "ethernet status:".$srow["ethernet_status_label"]."<br>";
    echo "solar sensor status:".$srow["solar_intensity_reading_invalid_label"]."<br>";	
    echo "realtime clock status:".$srow["realtime_clock_status_label"]."<br>";
    $timezoneseconds = $srow["timezoneseconds"];
    if ($timezoneseconds < 0) {
      $timezoneseconds = -$timezoneseconds;
      echo "timezone:-".gmdate("H:i:s",$timezoneseconds)."<br>";
    } else {
      echo "timezone:+".gmdate("H:i:s",$timezoneseconds)."<br>";
    }
    echo "synchronisation status:".$srow["timesyncstatus_label"]."<br>";
    echo "synchronisation mismatch (seconds RTC is ahead):".$srow["timemismatchRTCsecondsahead"]."<br>";
    echo "last assertion failure code:".$srow["assert_failure_code"]."<br>";
    echo "---temperature probe statuses---<br>";
    echo "hot inlet:".$srow["hx_hot_inlet_status_label"]."<br>";
    echo "hot outlet:".$srow["hx_hot_outlet_status_label"]."<br>";
    echo "cold inlet:".$srow["hx_cold_inlet_status_label"]."<br>";
    echo "cold outlet:".$srow["hx_cold_outlet_status_label"]."<br>";
    echo "ambient:".$srow["ambient_status_label"]."<br>";
?>
