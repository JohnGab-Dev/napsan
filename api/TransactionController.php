<?php
    session_start();
    require '../config/dbcon.php'; 

        if(isset($_POST['delSold'])){
            $id = mysqli_real_escape_string($con, $_GET['id']);

            $query = "SELECT * FROM productsold WHERE soldId = '$id'";
            $run_query = mysqli_query($con, $query);

            if(mysqli_num_rows($run_query)>0){
                $row = mysqli_fetch_array($run_query);
                $qty = $row['qty'];
                $prodId = $row['productId'];
                $total = $row['total'];
                $profit = $row['profit'];
                $transId = $row['transId'];

                $query2 = "SELECT * FROM products WHERE productId = '$prodId'";
                $run_query2 = mysqli_query($con, $query2);

                if(mysqli_num_rows($run_query2)>0){
                    $row1 = mysqli_fetch_array($run_query2);
                    $cqty = $row1['qty'];
                    $fqty = $cqty + $qty;

                    $query3 = "UPDATE products SET qty = '$fqty' WHERE productId = '$prodId'";
                    $run_query3 = mysqli_query($con, $query3);

                    if($run_query3){
                        $query4 = "SELECT * FROM transactions WHERE transId = '$transId'";
                        $run_query4 = mysqli_query($con, $query4);
                        if(mysqli_num_rows($run_query4)>0){
                            $row2 = mysqli_fetch_array($run_query4);
                            $subtotal = $row2['subtotal'];
                            $Ttotal = $row2['total'];
                            $Tprofit = $row2['profit'];

                            $subtotal = $subtotal - $total;
                            $Ttotal = $Ttotal - $total;
                            $Tprofit = $Tprofit - $profit;
                            if($Ttotal <= 0.00){
                                $query7 = "DELETE FROM transactions WHERE transId = '$transId'";
                                $run_query7 = mysqli_query($con, $query7);
                                if($run_query7){
                                    $_SESSION['success'] = 'Transaction Updated Successfully';
                                    header("Location: ../transactions.php");
                                    exit();
                                }else{
                                    $_SESSION['error'] = 'Something went wrong.. try again!';
                                    header("Location: ../editTr.php?id=$transId");
                                    exit();
                                }
                            }else{
                                $query5 = "UPDATE transactions SET subtotal = '$subtotal', total = '$Ttotal', profit = '$Tprofit' WHERE transId = '$transId'";
                                $run_query5 = mysqli_query($con, $query5);
                                if($run_query5){
                                    $query6 = "DELETE FROM productsold WHERE soldId = '$id'";
                                    $run_query6 = mysqli_query($con, $query6);
                                    if($run_query6){
                                        $_SESSION['success'] = 'Transaction Updated Successfully';
                                        header("Location: ../editTr.php?id=$transId");
                                        exit();
                                    }else{
                                        $_SESSION['error'] = 'Something went wrong.. try again!';
                                        header("Location: ../editTr.php?id=$transId");
                                        exit();
                                    }
                                }else{
                                    $_SESSION['error'] = 'Something went wrong.. try again!';
                                        header("Location: ../editTr.php?id=$transId");
                                        exit();
                                }
                            }
                            
                        }else{
                            $_SESSION['error'] = 'Something went wrong.. try again!';
                            header("Location: ../editTr.php?id=$transId");
                            exit();
                        }
                    }else{
                        $_SESSION['error'] = 'Something went wrong.. try again!';
                        header("Location: ../editTr.php?id=$transId");
                        exit();
                    }
                }else{
                    $_SESSION['error'] = 'Something went wrong.. try again!';
                    header("Location: ../editTr.php?id=$transId");
                    exit();
                }
            }else{
                $_SESSION['error'] = 'Something went wrong.. try again!';
                header("Location: ../editTr.php?id=$transId");
                exit();
            }
        }

        if(isset($_POST['save'])){
            $id = mysqli_real_escape_string($con, $_GET['id']);
            $subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
            $discount = mysqli_real_escape_string($con, $_POST['discount']);
            $total = mysqli_real_escape_string($con, $_POST['total']);

            $total = (float)str_replace(',', '', $total);
            // $amount = (float)str_replace(',', '', $amount);
            $subtotal = (float)str_replace(',', '', $subtotal);
            $discount = (float)str_replace(',', '', $discount);

            $query1 = "SELECT SUM(profit) as Profit FROM productsold WHERE transId = '$id'";
            $run_query1 = mysqli_query($con, $query1);

            if(mysqli_num_rows($run_query1)>0){
                $row = mysqli_fetch_array($run_query1);
                $profit = $row['Profit'];
                $profit = $profit - $discount;

                $query = "UPDATE transactions SET subtotal = '$subtotal', discount = '$discount', total = '$total', profit = '$profit' WHERE transId = '$id'";
                $run_query = mysqli_query($con, $query);

                if($run_query){
                    $_SESSION['success'] = 'Transaction Updated Successfully';
                    header("Location: ../transactions.php");
                    exit();
                }else{
                     $_SESSION['error'] = 'Something went wrong.. try again!';
                    header("Location: ../editTr.php?id=$transId");
                    exit();
                }
            }else{
                $_SESSION['error'] = 'Something went wrong.. try again!';
                header("Location: ../editTr.php?id=$transId");
                exit();
            }

        }

        if(isset($_POST['delTr'])){
            $id = mysqli_real_escape_string($con, $_GET['id']);
            $query = "DELETE FROM transactions WHERE transId = '$id'";
            $run_query = mysqli_query($con, $query);

            if($run_query){
                    $_SESSION['success'] = 'Transaction Deleted Successfully';
                    header("Location: ../transactions.php");
                    exit();
                }else{
                     $_SESSION['error'] = 'Something went wrong.. try again!';
                    header("Location: ../transactions.php");
                    exit();
                }

        }

        if(isset($_POST['date_filter'])){
            $date = mysqli_real_escape_string($con, $_POST['date']);

            header("Location: ../tr_history.php?date=$date");
            exit();
        }

        if(isset($_POST['delTrAll'])){
            $query = "DELETE FROM transactions";
            $run_query = mysqli_query($con, $query);
            if($run_query){
                $_SESSION['success'] = 'All Transactions Deleted Successfully';
                header("Location: ../tr_history.php");
                exit();
            }else{
                $_SESSION['error'] = 'Something went wrong.. try again!';
                header("Location: ../tr_history.php");
                exit();
            }
        }


    $con->close();
?>