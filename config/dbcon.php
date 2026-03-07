<?php
    date_default_timezone_set('Asia/Manila');
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "napsan";

    $con = mysqli_connect($hostname, $username, $password, $dbname);
    if(!$con){
        die("Connection Error".mysqli_connect_error());
    }

?>