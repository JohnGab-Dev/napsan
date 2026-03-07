<?php
    session_start();
    require '../config/dbcon.php'; 
    
    if(isset($_POST['addtocart'])){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $qty = mysqli_real_escape_string($con, $_POST['qty']);

        $s_query = "SELECT * FROM cart WHERE productId = '$id'";
        $s_run = mysqli_query($con, $s_query);

        if(mysqli_num_rows($s_run)>0){
            $row1 = mysqli_fetch_array($s_run);
            $old_qty = $row1['qty'];
            $cartId = $row1['cartId'];

            $query = "SELECT * FROM products WHERE productId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $srp = $row['srp'];
                $capital = $row['capital'];
                
                $new_qty = $old_qty + $qty;
                $total = $new_qty * $srp;
                $profit = ($srp - $capital) * $new_qty;

                $query1 = "UPDATE cart SET qty = '$new_qty', total = '$total', profit = '$profit' WHERE productId = '$id'";
                $run_query1 = mysqli_query($con, $query1);

                if($run_query1){
                    $_SESSION['successCart'] = 'Product Added to Cart';

                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../pos.php");
                        exit();
                    }
                }else{
                    $_SESSION['errorCart'] = 'Something went wrong try again!';
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../pos.php");
                        exit();
                    }
                }
            }else{
                $_SESSION['errorCart'] = 'Something went wrong try again!';
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header("Location: ../pos.php");
                    exit();
                }
            }  
        }else{
            $query = "SELECT * FROM products WHERE productId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $srp = $row['srp'];
                $capital = $row['capital'];
                $total = $qty * $srp;
                $profit = ($srp - $capital) * $qty;

                $query1 = "INSERT INTO cart(productId, qty, srp, capital, total, profit) VALUES ('$id', '$qty', '$srp', '$capital', '$total', '$profit')";
                $run_query1 = mysqli_query($con, $query1);

                if($run_query1){
                    $_SESSION['successCart'] = 'Product Added to Cart';
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../pos.php");
                        exit();
                    }
                }else{
                    $_SESSION['errorCart'] = 'Something went wrong try again!';
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../pos.php");
                        exit();
                    }
                }
            }else{
                $_SESSION['errorCart'] = 'Something went wrong try again!';
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        header("Location: ../pos.php");
                        exit();
                    }
            }  
        }
        
    }


    if(isset($_POST['delCart'])){
            $id = mysqli_real_escape_string($con, $_GET['id']);

            $query = "DELETE FROM cart WHERE cartId = '$id'";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                $_SESSION['successCart'] = 'Product Successfully Removed from cart';
                header("Location: ../pos.php");
                exit();
            }else{
                $_SESSION['errorCart'] = 'Something went wrong try again!';
                header("Location: ../pos.php");
                exit();
            }
        }

        if(isset($_POST['editCart'])){
            $id = mysqli_real_escape_string($con, $_GET['id']);
            $qty = mysqli_real_escape_string($con, $_POST['qty']);

            if($qty == 0){
                $query2 = "DELETE FROM cart WHERE cartId = '$id'";
                $run_query2 = mysqli_query($con, $query2);
                if($run_query2){
                    $_SESSION['successCart'] = 'Cart updated successfully';
                    header("Location: ../pos.php");
                    exit();
                }else{
                     $_SESSION['errorCart'] = 'Something went wrong try again!';
                    header("Location: ../pos.php");
                    exit();
                }
            }

            $query = "SELECT * FROM cart WHERE cartId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $srp = $row['srp'];
                $capital = $row['capital'];
                $total = $qty * $srp;
                $profit = ($srp - $capital) * $qty;

                $query1 = "UPDATE cart SET qty = '$qty', total = '$total', profit = '$profit' WHERE cartId = '$id'";
                $run_query1 = mysqli_query($con, $query1);

                if($run_query1){
                    $_SESSION['successCart'] = 'Cart updated successfully';
                    header("Location: ../pos.php");
                    exit();
                }else{
                     $_SESSION['errorCart'] = 'Something went wrong try again!';
                    header("Location: ../pos.php");
                    exit();
                }
            }else{
                $_SESSION['errorCart'] = 'Something went wrong try again!';
                header("Location: ../pos.php");
                exit();
            }

        }

        if(isset($_POST['abort'])){
            $query = "DELETE FROM cart";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                $_SESSION['successCart'] = 'Transaction aborted successfully';
                header("Location: ../pos.php");
                exit();
            }else{
                $_SESSION['errorCart'] = 'Something went wrong try again!';
                header("Location: ../pos.php");
                exit();
            }
        }

        if(isset($_POST['checkout'])){
            $subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
            $discount = mysqli_real_escape_string($con, $_POST['discount']);
            $total = mysqli_real_escape_string($con, $_POST['total']);
            $methods = mysqli_real_escape_string($con, $_POST['methods']);
            $amount = mysqli_real_escape_string($con, $_POST['amount']);
            $refnum = mysqli_real_escape_string($con, $_POST['refnum']);

            $total = (float)str_replace(',', '', $total);
            $amount = (float)str_replace(',', '', $amount);
            $subtotal = (float)str_replace(',', '', $subtotal);
            $discount = (float)str_replace(',', '', $discount);

            if($amount < $total){
                $_SESSION['errorCart'] = 'Amount Tendered must be equal or more than the total';
                header("Location: ../pos.php");
                exit();
            }else{
                if($methods == "Cash"){
                    $refnum = 'N/A';
                }else{
                    if($refnum == ''){
                        $_SESSION['errorCart'] = 'For Gcash Payment Ref Number Field is required!';
                        header("Location: ../pos.php");
                        exit();
                    }
                }
                
                $query = "SELECT SUM(profit) as Profit FROM cart";
                $run_query = mysqli_query($con, $query);

                if($run_query){
                    $row = mysqli_fetch_array($run_query);
                    $profit = $row['Profit'] - $discount;

                    $query1 = "INSERT INTO transactions(subtotal, discount, total, tendered, mode_of_payment, ref_num, profit) VALUES ('$subtotal', '$discount', '$total', '$amount', '$methods', '$refnum', '$profit')";
                    $run_query1 = mysqli_query($con, $query1);

                        if($run_query1){
                            $query2 = "SELECT * FROM transactions ORDER BY created_at DESC LIMIT 1";
                            $run_query2 = mysqli_query($con, $query2);

                            if(mysqli_num_rows($run_query2)>0){
                                $row1 = mysqli_fetch_array($run_query2);
                                $trId = $row1['transId'];

                                $query3 = "INSERT INTO productsold(productId, transId, qty, srp, capital, total, profit) SELECT productId, '$trId', qty, srp, capital, total, profit FROM cart";
                                $run_query3 = mysqli_query($con, $query3);
                                if($run_query3){
                                    $query5 = "SELECT * FROM cart";
                                    $run_query5 = mysqli_query($con, $query5);
                                    if(mysqli_num_rows($run_query5)>0){
                                        while($row2 = mysqli_fetch_array($run_query5)){
                                            $prodId = $row2['productId'];
                                            $cart_qty = $row2['qty'];
                                            $query6 = "SELECT * FROM products WHERE productId = '$prodId'";
                                            $run_query6 = mysqli_query($con, $query6);
                                            $row3 = mysqli_fetch_array($run_query6);
                                            $p_qty = $row3['qty'];
                                            $name = $row3['name'];

                                            $qty = $p_qty - $cart_qty;
                                            if($qty <= $row3['level_notif']){
                                                $query8 = "INSERT INTO notification(title, description, category, status) VALUES ('Products Low or Out of Stock', '$name now only has $qty stocks left. Please re-stock this product!', 'out-of-stock', 'UNREAD')";
                                                $run_query8 = mysqli_query($con, $query8);
                                            }

                                            $query7 = "UPDATE products SET qty = '$qty' WHERE productId = '$prodId'";
                                            $run_query7 = mysqli_query($con, $query7);
                                            if(!$run_query7){
                                                $_SESSION['errorCart'] = 'Something went wrong try again!';
                                                header("Location: ../pos.php");
                                                exit();
                                            }
                                        }
                                    }else{
                                        $_SESSION['errorCart'] = 'Something went wrong try again!';
                                        header("Location: ../pos.php");
                                        exit();
                                    }

                                    $query4 = "DELETE FROM cart";
                                    $run_query4 = mysqli_query($con, $query4);
                                        
                                    if($run_query4){
                                        $_SESSION['success'] = 'Transaction recorded successfully';
                                        header("Location: ../receipt.php?id=$trId");
                                        exit();
                                    }else{
                                        $_SESSION['errorCart'] = 'Something went wrong try again!';
                                        header("Location: ../pos.php");
                                        exit();
                                    }
                                }else{
                                    $_SESSION['errorCart'] = 'Something went wrong try again!';
                                    header("Location: ../pos.php");
                                    exit();
                                }
                            }else{
                                $_SESSION['errorCart'] = 'Something went wrong try again!';
                                header("Location: ../pos.php");
                                exit();
                            }
                        }else{
                            $_SESSION['errorCart'] = 'Something went wrong try again!';
                            header("Location: ../pos.php");
                            exit();
                        }
                }else{
                    $_SESSION['errorCart'] = 'Something went wrong try again!';
                    header("Location: ../pos.php");
                    exit();
                }

            }
            

        }

        
    $con->close();
?>