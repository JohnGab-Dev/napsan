<?php 
    session_start();
    require '../config/dbcon.php'; 

    if(isset($_POST['login'])){
        require '../methods/loginMidd.php';
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        if($username == '' || $password == ''){
            $_SESSION['error'] = 'All fields are required!';
            header("Location: ../login.php");
        }else{
            $query = "SELECT * FROM users WHERE username = '$username'";
            $run_query = mysqli_query($con, $query);
            if($run_query){
                if(mysqli_num_rows($run_query) > 0){
                    $row = mysqli_fetch_array($run_query);
                    
                    if(password_verify($password, $row['password'])){
                        $_SESSION['user'] = [
                            'id' => $row['userId'],
                            'username' => $row['username'],
                            'password' => $row['password'],
                            'role' => $row['role'],
                            'isLoggedIn' => 'yes'
                        ];

                        if($row['role'] == 'admin'){
                            $_SESSION['success'] = 'Welcome to Admins Dashboard';
                            header("Location: ../dashboard.php");
                            exit();
                        }else{
                             $_SESSION['success'] = 'Welcome to NAPSAN\'s POS';
                            header("Location: ../pos.php");
                            exit();
                        }
                    }else{
                        $_SESSION['error'] = 'Invalid username or password!';
                        header("Location: ../login.php");
                        exit();
                    }
                }else{
                    $_SESSION['error'] = 'Invalid username or password!';
                    header("Location: ../login.php");
                    exit();
                }
           
            }else{
                $_SESSION['error'] = 'Something Happened...Try Again!';
                header("Location: ../login.php");
                exit();
            }
        }
    }

    if(isset($_POST['fgot'])){
        require '../methods/loginMidd.php';
        $recov = mysqli_real_escape_string($con, $_POST['recov']);
        $username = mysqli_real_escape_string($con, $_POST['username']);

        if($recov == '' || $username == ''){
            $_SESSION['error'] = 'All fields are required';
            header("Location: ../forgot_pass.php");
            exit();
        }else{
            $query = "SELECT * FROM users WHERE username = '$username'";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                if(mysqli_num_rows($run_query)>0){
                    $row = mysqli_fetch_array($run_query);
                    if($row['RecoveryCode'] == $recov){
                        $_SESSION['fgot'] = [
                            'userId' => $row['userId'],
                            'recov' => $recov
                        ];
                        header('Location: ../changepass.php');
                        exit();
                    }else{
                        $_SESSION['error'] = 'Invalid Input';
                        header('Location: ../forgot_pass.php');
                        exit();
                    }
                }else{
                    $_SESSION['error'] = 'Invalid Input';
                    header('Location: ../forgot_pass.php');
                    exit();
                }
            }else{
                $_SESSION['error'] = 'Something went wrong....try again!';
                header('Location: ../forgot_pass.php');
                exit();
            }
        }
    }

    if(isset($_POST['save'])){
        require '../methods/loginMidd.php';
        $npass = mysqli_real_escape_string($con, $_POST['npass']);
        $cpass = mysqli_real_escape_string($con, $_POST['cpass']);

        if($npass == '' || $cpass == ''){
            $_SESSION['error'] = 'All fields are required';
            header("Location: ../changepass.php");
        }else if($npass != $cpass){
            $_SESSION['error'] = 'Passwords do not match!!';
            header("Location: ../changepass.php");
        }else{
            $id = $_SESSION['fgot']['userId'];
            $new_password = password_hash($npass, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = '$new_password' WHERE userId = '$id'";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                unset($_SESSION['fgot']);
                $_SESSION['success'] = 'Password changed...Try logging in!';
                header("Location: ../login.php");
                exit();
            }else{
                $_SESSION['error'] = 'Something went wrong....try again!';
                header('Location: ../changepass.php');
                exit();
            }
        }
    }

    


    $con->close();
?>