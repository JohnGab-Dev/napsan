<?php
if(isset($_SESSION['user'])){
        if($_SESSION['user']['role'] == 'admin'){
            header("Location: dashboard.php");
            exit();
        }else if($_SESSION['user']['role'] == 'cashier'){
            header("Location: pos.php");
            exit();
        }
    }

?>