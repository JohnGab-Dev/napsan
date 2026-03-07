<?php
    session_start();
    require '../config/dbcon.php'; 
        if(isset($_POST['find'])){
            $search = mysqli_real_escape_string($con, $_POST['search']);
            if($search == ''){
                header("Location: ../pos.php");
                exit();
            }
            header("Location: ../pos.php?search=$search");
            exit();
        }

        if(isset($_POST['findProd'])){
            $search = mysqli_real_escape_string($con, $_POST['search']);
             if($search == ''){
                header("Location: ../inventory.php");
                exit();
            }
            
            header("Location: ../inventory.php?search=$search");
            exit();
        }

    $con->close();
?>