<?php 
session_start();
$title = "Napsan Pharmacy || Dashboard";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/alerts.php';
require 'methods/expiryMethod.php';
require 'methods/checkInvent.php';

    if($_SESSION['user']['role'] == 'cashier'){
        echo "<script>window.location.href = 'pos.php'</script>";
    }
    
    if(isset($_GET['year'])){
        $year = mysqli_real_escape_string($con, $_GET['year']);

        $query1 = "SELECT SUM(qty) as total FROM productsold WHERE YEAR(date_created) = '$year' GROUP BY date_created";
        $query4 = "SELECT SUM(profit) as prof FROM transactions WHERE YEAR(date_created) = '$year' GROUP BY date_created";
        $query15 = "SELECT SUM(profit) as prof FROM transactions WHERE YEAR(date_created) = '$year'";
    }else{
         $query1 = "SELECT SUM(qty) as total FROM productsold GROUP BY date_created";
         $query4 = "SELECT SUM(profit) as prof FROM transactions GROUP BY date_created";
         $query15 = "SELECT SUM(profit) as prof FROM transactions";
    }
    $query = "SELECT * FROM products";
    $run_query = mysqli_query($con, $query);
    $num_of_products = mysqli_num_rows($run_query);

    $run_query1 = mysqli_query($con, $query1);
    $row = mysqli_fetch_array($run_query1);
    $num_of_days = mysqli_num_rows($run_query1);

    $query2 = "SELECT * FROM stock_expiry WHERE status = 'Near Expiry' OR status = 'Expired'";
    $run_query2 = mysqli_query($con, $query2);
    $num_of_expiring = mysqli_num_rows($run_query2);

    $query3 = "SELECT * FROM products WHERE status = 'Low Stocks' OR status = 'Out of Stock'";
    $run_query3 = mysqli_query($con, $query3);
    $num_of_low = mysqli_num_rows($run_query3);
    
    $run_query4 = mysqli_query($con, $query4);
    $row1 = mysqli_fetch_array($run_query4);
    $num_of_trans = mysqli_num_rows($run_query4);

    $run_query15 = mysqli_query($con, $query15);
    $row15 = mysqli_fetch_array($run_query15);
?>

<div class="w-full h-screen pt-14 p-2 pb-4">
    <div class="w-full h-full flex flex-col gap-2">
        <div class="w-full h-1/5 flex gap-2">
            <div class="w-1/4 h-full rounded-sm border-r-4 border-green-600 bg-white shadow-lg p-2">
                <h1 class="font-medium">Total Products</h1>
                <h1 class="text-5xl text-center mt-2"><?= number_format($num_of_products, 0)?></h1>
            </div>

            <div class="w-1/4 h-full rounded-sm border-r-4 border-blue-600 bg-white shadow-lg p-2">
                <h1 class="font-medium">Average Sales Per Day</h1>
                <h1 class="text-5xl text-center mt-2"><?= $num_of_days == 0 ? '0' : number_format($row['total'] / $num_of_days, 0) ?></h1>
            </div>

            <div class="w-1/4 h-full rounded-sm border-r-4 border-yellow-600 bg-white shadow-lg p-2">
                <h1 class="font-medium">Sub-Revenue</h1>
                <h1 class="text-2xl text-center mt-5 font-medium">P <?= $num_of_trans == 0 ? '0': number_format($row15['prof'])?></h1>
            </div>

            <div class="w-1/4 h-full rounded-sm border-r-4 border-red-600 bg-white shadow-lg p-2">
                <h1 class="font-medium">Estimated Revenue</h1>
                <h1 class="text-2xl text-center mt-5 font-medium">P <?= $num_of_trans == 0 ? '0': number_format($row15['prof'] - ($num_of_trans * 3300), 2)?></h1>
            </div>
        </div>

        <div class="w-full h-4/5 flex gap-2">
            <div class="w-1/5 h-full flex flex-col gap-2 ">
                <div class="w-full h-1/3 rounded-sm bg-white shadow-lg p-4 flex flex-col gap-1">
                    <h1 class="font-medium text-xs">Filter Year</h1>
                    <form action="api/dashboardController.php" method="post" class="flex flex-col gap-1">
                        <select name="year" id="year" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                            <option value="">--SELECT--</option>
                            <?php 
                            $query7 = "SELECT YEAR(date_created) as years FROM transactions GROUP BY MONTH(date_created) ORDER BY YEAR(date_created) ASC";
                            $run_query7 = mysqli_query($con, $query7);
                            
                            if(mysqli_num_rows($run_query7)>0){
                                while($row4 = mysqli_fetch_array($run_query7)){
                                    $year = $row4['years'];
                            ?>
                            <option value="<?= $year?>"><?= $year?></option>
                        <?php
                                }
                            }     
                        ?>
                        </select>
                        <button type="submit" name="filter_year" class="text-sm px-4 h-8 bg-blue-600 text-white font-semibold hover:bg-blue-700 active:opacity-80">Filter</button>
                    </form>
                </div>
                <div class="w-full h-1/3 rounded-sm bg-white shadow-lg p-4">
                    <h1 class="font-medium">Expiring Products</h1>
                    <h1 class="text-5xl text-center mt-2"><?= $num_of_expiring?></h1>
                </div>
                <div class="w-full h-1/3 rounded-sm bg-white shadow-lg p-4">
                    <h1 class="font-medium">Low to Zero Stocks</h1>
                    <h1 class="text-5xl text-center mt-2"><?= $num_of_low?></h1>
                    
                </div>
                
            </div>
            <div class="w-[33%] h-full rounded-sm bg-white shadow-lg p-2 flex flex-col gap-2 overflow-y-auto">
                <h1 class="font-medium">Sales Last 30 Days</h1>
                <table class="text-sm">
                    <thead>
                        <tr class="font-semibold bg-green-600 text-white">
                            <td class="p-1 border">Date</td>
                            <td class="p-1 border">Total Sales</td>
                            <td class="p-1 border">Sub-Profit</td>
                            <td class="p-1 border">Estimated Profit</td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $query5 = "SELECT SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions GROUP BY date_created ORDER BY date_created DESC LIMIT 30 ";
                            $run_query5 = mysqli_query($con, $query5);
                            
                            if(mysqli_num_rows($run_query5)>0){
                                while($row2 = mysqli_fetch_array($run_query5)){
                                    $date = date('l, F j, Y', strtotime($row2['date_created']));
                        ?>
                        <tr class="border-b font-medium hover:bg-slate-100">
                            <td class="p-1 border border-slate-400"><?= $date?></td>
                            <td class="p-1 border border-slate-400"><?= $row2['Total']?></td>
                            <td class="p-1 border border-slate-400"><?= $row2['Subprofit']?>(<?= number_format(($row2['Subprofit']/$row2['Total'])*100, 2)?>%)</td>
                            <td class="p-1 border border-slate-400"><?= $row2['Subprofit'] - 3300?></td>
                        </tr>
                        <?php
                                }
                            }else{

                              
                        ?>
                            <tr class="text-center">
                                <td colspan="4" class="p-1 font-medium">No Sales Found!</td>
                            </tr>
                        <?php
                             }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="w-[31%] h-full rounded-sm bg-white shadow-lg p-2 flex flex-col gap-2 overflow-y-auto">
                <h1 class="font-medium">Sales per Month</h1>
                <table class="text-sm">
                    <thead>
                        <tr class="font-semibold bg-yellow-600 text-white">
                            <td class="p-1 border">Date</td>
                            <td class="p-1 border">Total Sales</td>
                            <td class="p-1 border">Sub-Profit</td>
                            <td class="p-1 border">Estimated Profit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($_GET['year'])){
                            $query6 = "SELECT MONTH(date_created) as MM, SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions WHERE YEAR(date_created) = '$year' GROUP BY MONTH(date_created) ORDER BY MONTH(date_created) ASC";
                        }else{
                            $query6 = "SELECT MONTH(date_created) as MM, SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions GROUP BY MONTH(date_created) ORDER BY MONTH(date_created) ASC";
                        }
                            
                            $run_query6 = mysqli_query($con, $query6);
                            
                            if(mysqli_num_rows($run_query6)>0){
                                while($row3 = mysqli_fetch_array($run_query6)){
                                    $date_created = $row3['date_created'];
                                    $date_created = date("F", strtotime($date_created));
                                    $MM = $row3['MM'];
                                if(isset($_GET['year'])){
                                    $query8 = "SELECT * FROM transactions WHERE MONTH(date_created) = '$MM' AND YEAR(date_created) = '$year' GROUP BY date_created";
                                }else{
                                    $query8 = "SELECT * FROM transactions WHERE MONTH(date_created) = '$MM' GROUP BY date_created";
                                }
                                    
                                    $run_query8 = mysqli_query($con, $query8);
                                    $num_days = mysqli_num_rows($run_query8);
                        ?>
                        <tr class="border-b font-medium hover:bg-slate-100">
                            <td class="p-1 border border-slate-400"><?= $date_created?></td>
                            <td class="p-1 border border-slate-400"><?= $row3['Total']?></td>
                            <td class="p-1 border border-slate-400"><?= $row3['Subprofit']?>(<?= number_format(($row3['Subprofit']/$row3['Total'])*100, 2)?>%)</td>
                            <td class="p-1 border border-slate-400"><?= $row3['Subprofit'] - ($num_days * 3300)?> </td>
                        </tr>
                        <?php
                                }
                            }else{ 
                        ?>
                            <tr class="text-center">
                                <td colspan="4" class="p-1 font-medium">No Sales Found!</td>
                            </tr>
                        <?php
                             }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="w-[16%] h-full rounded-sm bg-white shadow-lg p-2 flex flex-col gap-2 overflow-y-auto">
                <h1 class="font-medium">10 Best Selling</h1>
                <table class="text-sm">
                    <thead>
                        <tr class="font-semibold bg-blue-600 text-white">
                            <td class="p-1 border">Product Name</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(isset($_GET['year'])){
                                $query9 = "SELECT products.name, SUM(productsold.qty) as QTY FROM productsold JOIN products ON productsold.productId = products.productId WHERE YEAR(date_created) = '$year' GROUP BY productsold.productId ORDER BY SUM(productsold.qty) DESC LIMIT 10";

                               
                            }else{
                                $query9 = "SELECT products.name, SUM(productsold.qty) as QTY FROM productsold JOIN products ON productsold.productId = products.productId GROUP BY productsold.productId ORDER BY SUM(productsold.qty) DESC LIMIT 10";
                            }
                            
                            $run_query9 = mysqli_query($con, $query9);
                            
                            if(mysqli_num_rows($run_query9)>0){
                                while($row5 = mysqli_fetch_array($run_query9)){
                        ?>

                        <tr class="border-b font-medium hover:bg-slate-100">
                            <td class="p-1 border border-slate-400"><?= $row5['name']?> - <span class="p-0.5 rounded-sm bg-green-200"><?= $row5['QTY']?> sold</span>  </td>
                        </tr>
                        <?php
                                }
                            }else{  
                        ?>
                            <tr class="text-center">
                                <td colspan="9" class="p-1 font-medium">No Products Found!</td>
                            </tr>
                        <?php
                             }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/__footer.php';?>