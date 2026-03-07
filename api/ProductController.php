<?php
    session_start();
    require '../config/dbcon.php'; 

    if(isset($_POST['addProd'])){
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $qty = mysqli_real_escape_string($con, $_POST['qty']);
        $expiry = mysqli_real_escape_string($con, $_POST['expiry']);
        $distrib = mysqli_real_escape_string($con, $_POST['distrib']);
        $srp = mysqli_real_escape_string($con, $_POST['srp']);
        $capital = mysqli_real_escape_string($con, $_POST['capital']);
        $level = mysqli_real_escape_string($con, $_POST['level']);

        if($qty <= $level && $qty > 0 ){
            $status = "Low Stocks";
            $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
            $run_query8 = mysqli_query($con, $query8);
        
        }else if($qty > $level){
            $status = "Good";
        }else{
            $status = "Out of Stock";
            $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
            $run_query8 = mysqli_query($con, $query8);
        }
            $today = new DateTime(date('Y-m-d'));
            $expiry = new DateTime($expiry);
            $diff = $today->diff($expiry);
            $days_diff = (int)$diff->format('%r%a');
            if ($days_diff > 150) {
                $expiry_status = "Good";
            } else if ($days_diff <= 150 && $days_diff > 0) {
                $expiry_status = "Near Expiry";
            } else {
                $expiry_status = "Expired";
            }

            $query = "INSERT INTO `products`(`name`, `qty`, `srp`, `capital`, `distributor`,`level_notif`, `status`) VALUES ('$name','$qty','$srp','$capital','$distrib', '$level','$status')";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                $query1 = "SELECT * FROM products ORDER BY created_at DESC LIMIT 1";
                $run_query1 = mysqli_query($con, $query1);

                if(mysqli_num_rows($run_query1)>0){
                    if($qty > 0){
                        $row = mysqli_fetch_array($run_query1);
                        $prodId = $row['productId'];
                        $expiry = $expiry->format('Y-m-d');
                        $query2 = "INSERT INTO stock_expiry(productId, stocks_in, expiry, status) VALUES ('$prodId','$qty','$expiry','$expiry_status')";
                        $run_query2 = mysqli_query($con, $query2);

                        if($run_query2){
                            $_SESSION['success'] = 'Product Successfully Added';
                            
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                header("Location: " . $_SERVER['HTTP_REFERER']);
                                exit();
                            } else {
                                header("Location: ../inventory.php");
                                exit();
                            }

                        }else{
                            $_SESSION['error'] = 'Something went wrong try again!';
                            echo "<script>window.history.back();</script>";
                        }
                    }else{
                        $_SESSION['success'] = 'Product Successfully Added';
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            header("Location: " . $_SERVER['HTTP_REFERER']);
                            exit();
                        } else {
                            header("Location: ../inventory.php");
                            exit();
                        }
                    }
                    
                }else{
                    $_SESSION['error'] = 'Something went wrong try again!';
                    echo "<script>window.history.back();</script>";
                }
            }else{
                $_SESSION['error'] = 'Something went wrong try again!';
                echo "<script>window.history.back();</script>";
            }
        
    }

    if(isset($_POST['addStock'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $expiry = mysqli_real_escape_string($con, $_POST['expiry']);
        $qty = mysqli_real_escape_string($con, $_POST['qty']);
        $srp = mysqli_real_escape_string($con, $_POST['srp']);
        $capital = mysqli_real_escape_string($con, $_POST['capital']);

            $today = new DateTime(date('Y-m-d'));
            $expiry = new DateTime($expiry);
            $diff = $today->diff($expiry);
            $days_diff = (int)$diff->format('%r%a');
            if ($days_diff > 150) {
                $expiry_status = "Good";
            } else if ($days_diff <= 150 && $days_diff > 0) {
                $expiry_status = "Near Expiry";
            } else {
                $expiry_status = "Expired";
            }

            $expiry = $expiry->format('Y-m-d');
            $query = "INSERT INTO stock_expiry(productId, stocks_in, expiry, status) VALUES ('$id', '$qty', '$expiry', '$expiry_status')";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                $query1 = "SELECT * FROM products WHERE productId = $id";
                $run_query1 = mysqli_query($con, $query1);

                if(mysqli_num_rows($run_query1)>0){
                    $row = mysqli_fetch_array($run_query1);
                    $qty = $qty + $row['qty'];
                    $level = $row['level_notif'];

                    if($qty <= $level && $qty > 0 ){
                        $status = "Low Stocks";
                        $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
                        $run_query8 = mysqli_query($con, $query8);
                    
                    }else if($qty > $level){
                        $status = "Good";
                    }else{
                        $status = "Out of Stock";
                        $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
                        $run_query8 = mysqli_query($con, $query8);
                    }
                    
                    $query3 = "UPDATE products SET qty = '$qty', srp = '$srp', capital = '$capital', status = '$status' WHERE productId = '$id'";
                    $run_query3 = mysqli_query($con, $query3);

                    if($run_query3){
                        $_SESSION['success'] = 'Stocks Successfully Added';
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                header("Location: " . $_SERVER['HTTP_REFERER']);
                                exit();
                            } else {
                                header("Location: ../inventory.php");
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
                $_SESSION['error'] = 'Something went wrong try again!';
                echo "<script>window.history.back();</script>";
            }
        
    }

    if(isset($_POST['editProd'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $qty = mysqli_real_escape_string($con, $_POST['qty']);
        $distrib = mysqli_real_escape_string($con, $_POST['distrib']);
        $srp = mysqli_real_escape_string($con, $_POST['srp']);
        $capital = mysqli_real_escape_string($con, $_POST['capital']);
        $level = mysqli_real_escape_string($con, $_POST['level']);

        if($qty <= $level && $qty > 0){
            $status = "Low Stocks";
            $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
            $run_query8 = mysqli_query($con, $query8);
        }else if($qty > $level){
            $status = "Good";
        }else{
            $status = "Out of Stock";
            $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
            $run_query8 = mysqli_query($con, $query8);
        }

        $query = "UPDATE products SET name = '$name', qty = '$qty', distributor = '$distrib', srp = '$srp', capital = '$capital', status = '$status', level_notif = '$level' WHERE productId = '$id'";

        $run_query = mysqli_query($con, $query);

        if($run_query){
            $_SESSION['success'] = 'Product Successfully Updated';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }

    }

    if(isset($_POST['delProd'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $query = "DELETE FROM products WHERE productId = '$id'";
        $run_query = mysqli_query($con, $query);

        if($run_query){
            $_SESSION['success'] = 'Product Successfully Deleted';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }
    }


    if(isset($_POST['editStock'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $qty = mysqli_real_escape_string($con, $_POST['qty']);
        $expiry = mysqli_real_escape_string($con, $_POST['expiry']);

        $query = "SELECT * FROM stock_expiry WHERE stId = '$id'";
        $run_query = mysqli_query($con, $query);

        if(mysqli_num_rows($run_query) > 0){
            $row = mysqli_fetch_array($run_query);
            $stock_in = $row['stocks_in'];
            $prodId = $row['productId'];

            $query1 = "SELECT * FROM products WHERE productId = '$prodId'";
            $run_query1 = mysqli_query($con, $query1);

            if(mysqli_num_rows($run_query1) > 0){
                $row1 = mysqli_fetch_array($run_query1);
                $qty_pr = $row1['qty'];

                $qty_pr = ($qty_pr + $qty) - $stock_in;

                $query2 = "UPDATE products SET qty = '$qty_pr' WHERE productId = '$prodId'";
                $run_query2 = mysqli_query($con, $query2);
                if($run_query2){
                        $expiry = new DateTime($expiry);
                        $expiry = $expiry->format('Y-m-d');

                        $query3 = "UPDATE stock_expiry SET stocks_in = '$qty', expiry = '$expiry' WHERE stId = '$id'";
                        $run_query3 = mysqli_query($con, $query3);

                        if($run_query3){
                            $_SESSION['success'] = 'Stock Delivery Successfully Updated';
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                header("Location: " . $_SERVER['HTTP_REFERER']);
                                exit();
                            } else {
                                header("Location: ../stocks.php");
                                exit();
                            }
                        }else{
                            $_SESSION['error'] = 'Something went wrong try again!';
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                header("Location: " . $_SERVER['HTTP_REFERER']);
                                exit();
                            } else {
                                header("Location: ../stocks.php");
                                exit();
                            }
                        }
                    
                }else{
                    $_SESSION['error'] = 'Something went wrong try again!';
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../stocks.php");
                        exit();
                    }
                }

            }else{
                $_SESSION['error'] = 'Something went wrong try again!';
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../stocks.php");
                    exit();
                }
            }  
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../stocks.php");
                exit();
            }
        }
    }

    if(isset($_POST['expiring'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);

        $query = "SELECT * FROM stock_expiry WHERE stId = '$id'";
        $run_query = mysqli_query($con, $query);

        if(mysqli_num_rows($run_query)>0){
            $row = mysqli_fetch_array($run_query);
            $status = $row['status'];
            $status = $status . '-processed';

            $query1 = "UPDATE stock_expiry SET status = '$status' WHERE stId = '$id'";
            $run_query1 = mysqli_query($con, $query1);

            if($run_query1){
                $_SESSION['success'] = 'Stocks Status Changed Successfully';

                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../expiring.php");
                    exit();
                }
            }else{
                $_SESSION['error'] = 'Something went wrong try again!';

                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../expiring.php");
                    exit();
                }
            }
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../expiring.php");
                exit();
            }
        }

    }

    if(isset($_POST['delStockAll'])){
        $query = "DELETE FROM stock_expiry";
        $run_query = mysqli_query($con, $query);

        if($run_query){
            $_SESSION['success'] = 'All Stocks Data Deleted Permanently!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../stocks.php");
                exit();
            }
        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../stocks.php");
                exit();
            }
        }
    }

    if(isset($_POST['hide'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);

        $query = "UPDATE products SET status = 'hidden' WHERE productId = '$id'";
        $run_query = mysqli_query($con, $query);

        if($run_query){
             $_SESSION['success'] = 'Product successfully archived!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }else{
             $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }
    }

    if(isset($_POST['unhide'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);

        $query1 = "SELECT * FROM products WHERE productId = '$id'";
        $run_query1 = mysqli_query($con, $query1);

        if(mysqli_num_rows($run_query1)>0){
            $row = mysqli_fetch_array($run_query1);
            $qty = $row['qty'];
            $level = $row['level_notif'];

            if($qty <= $level && $qty > 0 ){
                $status = "Low Stocks";
                $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
                $run_query8 = mysqli_query($con, $query8);
                    
            }else if($qty > $level){
                $status = "Good";
            }else{
                $status = "Out of Stock";
                $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
                $run_query8 = mysqli_query($con, $query8);
            }

            $query = "UPDATE products SET status = '$status' WHERE productId = '$id'";
            $run_query = mysqli_query($con, $query);
            if($run_query){
                $_SESSION['success'] = 'Product successfully unarchived!';
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../inventory.php");
                    exit();
                }
            }else{
                $_SESSION['error'] = 'Something went wrong try again!';
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../inventory.php");
                    exit();
                }
            }

        }else{
            $_SESSION['error'] = 'Something went wrong try again!';
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header("Location: ../inventory.php");
                exit();
            }
        }


    }

    $con->close();
?>