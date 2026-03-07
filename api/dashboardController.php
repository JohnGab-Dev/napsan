<?php 
    session_start();
    require '../config/dbcon.php'; 

    if(isset($_POST['filter_year'])){
        $year = mysqli_real_escape_string($con, $_POST['year']);
        header("Location: ../dashboard.php?year=$year");
        exit();
    }

    $con->close();
?>