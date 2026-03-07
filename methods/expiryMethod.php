<?php 
    $query20 = "SELECT * FROM stock_expiry WHERE (status = 'Near Expiry' OR status = 'Expired') AND notified = 0";
    $run_query20 = mysqli_query($con, $query20);

    if(mysqli_num_rows($run_query20)>0){
        $query21 = "INSERT INTO notification(title, description, category, status) VALUES ('Expiring Products', 'There are products that are about to expire!....To remove the spam please mark them as processed!', 'Expiry', 'UNREAD')";
        $run_query21 = mysqli_query($con, $query21);

        $query22 = "UPDATE stock_expiry SET notified = 1 WHERE status = 'Near Expiry' OR status = 'Expired'";
        $run_query22 = mysqli_query($con, $query22);
    }
?>