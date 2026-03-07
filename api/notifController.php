<?php
    session_start();
    require '../config/dbcon.php'; 
    
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $query = "UPDATE notification SET status = 'READ' WHERE notifId = '$id'";
        $run_query = mysqli_query($con, $query);
        if($run_query){
        $query1 = "SELECT * FROM notification WHERE notifId = '$id'";
        $run_query1 = mysqli_query($con, $query1);

        if(mysqli_num_rows($run_query1)>0){
            $row = mysqli_fetch_array($run_query1);

            if($row['category'] == 'Expiry'){
                header("Location: ../expiring.php");
                exit();
            }else{
                header("Location: ../low_stock.php");
                exit();
            }
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            echo "<script>window.history.back();</script>";
        }
     }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            echo "<script>window.history.back();</script>";
     }

    }else{
        $query = "UPDATE notification SET status = 'READ'";
        $run_query = mysqli_query($con, $query);
        header("Location: ". $_SERVER['HTTP_REFERER']);
        exit();
    }

     

     
   
    $con->close();
?>