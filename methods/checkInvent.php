<?php
    $query23 = "UPDATE products SET status = 'Low Stocks'  WHERE qty <= level_notif AND qty > 0 AND status != 'hidden'";
    $run_query23 = mysqli_query($con, $query23);

    $query24 = "UPDATE products SET status = 'Out of Stock'  WHERE qty <= 0 AND status != 'hidden'";
    $run_query24 = mysqli_query($con, $query24);

    $query25 = "UPDATE products SET status = 'Good'  WHERE qty > level_notif AND status != 'hidden'";
    $run_query25 = mysqli_query($con, $query25);

    $query26 = "DELETE FROM stock_expiry WHERE productId IN (SELECT productId FROM products WHERE qty <= 0)";
    $run_query26=mysqli_query($con, $query26);
?>