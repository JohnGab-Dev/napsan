<?php 
session_start();

    unset($_SESSION['user']);
    $_SESSION['success'] = 'Logged out successful!';
    header("Location: ../login.php");

?>