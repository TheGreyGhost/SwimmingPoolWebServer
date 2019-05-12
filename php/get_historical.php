<?php
    require "db_historical_connect.php";

    // get the requested historical data range 
    $sql = "SELECT `timestampUTC`,`hx_hot_inlet_ave`,`hx_hot_outlet_ave`, `hx_cold_inlet_ave`,`hx_cold_outlet_ave`,`temp_ambient_ave`,`cumulative_insolation`,`surgetank_level`,`pump_runtime`,`pump_state` FROM `LoggedData` ORDER BY timestampUTC LIMIT 20000;";
    $result = mysqli_query($conn_hist, $sql);
    $historydata = mysqli_fetch_all($result);
    mysqli_free_result($result);
    
    $sql = "SELECT pump_state_code, pump_state_label FROM PumpStateLabels;";
    $result = mysqli_query($conn_hist, $sql);
    $pumplabels = mysqli_fetch_all($result);
    mysqli_free_result($result);
    
    mysqli_close($conn_hist);

if(empty($historydata)) {
    // you have no results to work with so perhaps handle this as error condition and exit/redirect.
  die("No data found");
}
?>

