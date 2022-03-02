<?php
// DB_REALTIME_CONNECT.PHP
    // Set database login details
    $servername = "localhost";
    $username_hist = "webserverreadonly";
    $password_hist = "gorflune";
    $dbname_hist = "AutomationServerHistory";

    // Create connection

    $conn_hist = mysqli_connect($servername, $username_hist, $password_hist, $dbname_hist);

    // Check connection

    if (!$conn_hist) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>