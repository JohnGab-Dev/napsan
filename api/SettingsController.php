<?php
    session_start();
    require '../config/dbcon.php'; 

    if(isset($_POST['changePass'])){
        $opass = mysqli_real_escape_string($con, $_POST['opass']);
        $npass = mysqli_real_escape_string($con, $_POST['npass']);
        $cpass = mysqli_real_escape_string($con, $_POST['cpass']);

        if($opass == '' || $cpass == '' || $npass == ''){
            $_SESSION['error'] = 'Please Fill All Fields!';
            header("Location: ../settings.php");
            exit();
        }else{
            $id = $_SESSION['user']['id'];

            $query = "SELECT * FROM users WHERE userId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $currPass = $row['password'];

                if(password_verify($opass, $currPass)){
                    if($cpass == $npass){
                        $newpass = password_hash($npass, PASSWORD_DEFAULT);
                        $query1 = "UPDATE users SET password = '$newpass' WHERE userId = '$id'";
                        $run_query1 = mysqli_query($con, $query1);

                        if($run_query1){
                            $_SESSION['success'] = 'Password Changed Successfully...Please re-login your account.';
                            unset($_SESSION['user']);
                            header("Location: ../login.php");
                            exit();
                        }
                    }else{
                        $_SESSION['error'] = 'Passwords Do not match!';
                        header("Location: ../settings.php");
                        exit();
                    }
                }else{
                    $_SESSION['error'] = 'Invalid old password!';
                    header("Location: ../settings.php");
                    exit();
                } 
            }else{
                $_SESSION['error'] = 'Something went wrong....try again!';
                header("Location: ../settings.php");
                exit();
            }
        } 
    }

    if(isset($_POST['changeRc'])){
        $oldRc = mysqli_real_escape_string($con, $_POST['oldRc']);
        $nRc = mysqli_real_escape_string($con, $_POST['nRc']);
        $cRc = mysqli_real_escape_string($con, $_POST['cRc']);

        if($oldRc == '' || $nRc == '' || $cRc == ''){
            $_SESSION['error'] = 'Please Fill All Fields!';
            header("Location: ../changeRec.php");
            exit();
        }else{
            $id = $_SESSION['user']['id'];

            $query = "SELECT * FROM users WHERE userId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $recov = $row['RecoveryCode'];

                if($recov == $oldRc){
                    if($nRc == $cRc){
                        $query1 = "UPDATE users SET RecoveryCode = '$nRc'";
                        $run_query1 = mysqli_query($con, $query1);

                        if($run_query1){
                            $_SESSION['success'] = 'Recovery Code Changed Successfully...You can now use it to recover an account!.';
                            header("Location: ../changeRec.php");
                            exit();
                        }
                    }else{
                        $_SESSION['error'] = 'New recovery codes do not match!';
                        header("Location: ../changeRec.php");
                        exit();
                    }
                }else{
                    $_SESSION['error'] = 'Invalid Old Recovery Code!';
                    header("Location: ../changeRec.php");
                    exit();
                } 
            }else{
                $_SESSION['error'] = 'Something went wrong....try again!';
                header("Location: ../changeRec.php");
                exit();
            }
        } 
    }

    if(isset($_POST['delSoldAll'])){
        $query = "DELETE FROM productsold";
            $run_query = mysqli_query($con, $query);
            if($run_query){
                $_SESSION['success'] = 'All Sold Products are Deleted Successfully';
                header("Location: ../transacSettings.php");
                exit();
            }else{
                $_SESSION['error'] = 'Something went wrong.. try again!';
                header("Location: ../transacSettings.php");
                exit();
            }
    }

        if(isset($_POST['delNotifAll'])){
        $query = "DELETE FROM notification";
            $run_query = mysqli_query($con, $query);
            if($run_query){
                $_SESSION['success'] = 'All Notifications are Deleted Successfully';
                header("Location: ../notifSettings.php");
                exit();
            }else{
                $_SESSION['error'] = 'Something went wrong.. try again!';
                header("Location: ../notifSettings.php");
                exit();
            }
    }



    $con->close();
?>