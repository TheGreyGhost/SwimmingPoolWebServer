<?php
// DB_REALTIME_CONNECT.PHP
    // Set database login details
    $servername = "localhost";
    $username_rt = "webserverreadonly";
    $password_rt = "gorflune";
    $dbname_rt = "AutomationServerHistory";

    // Create connection

    $conn_rt = mysqli_connect($servername, $username_rt, $password_rt, $dbname_rt);

    // Check connection

    if (!$conn_rt) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>