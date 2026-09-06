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

    //year declaration
    $year = "";
    if(isset($_GET['year'])){
        $year = mysqli_real_escape_string($con, $_GET['year']);
    }
    
    
    if($year && $year != ""){
        $year = mysqli_real_escape_string($con, $_GET['year']);
        //sales per day query
        $query1 = "SELECT SUM(qty) as total FROM productsold WHERE YEAR(created_at) = '$year' GROUP BY DATE(created_at)";
        //get total qty SUM
        $qtysumQuery = "SELECT SUM(qty) as grandtotal FROM productsold WHERE YEAR(created_at) = '$year'";
        //no of transactions
        $query4 = "SELECT SUM(profit) as prof FROM transactions WHERE YEAR(date_created) = '$year' GROUP BY date_created";
        //total profit and date created
        $query15 = "SELECT SUM(profit) as prof, date_created FROM transactions WHERE YEAR(date_created) = '$year'";
    }else{
        //sales per day query
        $query1 = "SELECT SUM(qty) as total FROM productsold GROUP BY DATE(created_at)";
        //get total qty SUM
        $qtysumQuery = "SELECT SUM(qty) as grandtotal FROM productsold";
        //no of transactions
        $query4 = "SELECT SUM(profit) as prof FROM transactions GROUP BY date_created";
        //total profit and date created
        $query15 = "SELECT SUM(profit) as prof, date_created FROM transactions";
    }
    //no of products query
    $query = "SELECT * FROM products";
    $run_query = mysqli_query($con, $query);
    $num_of_products = mysqli_num_rows($run_query);

    //sales per day query
    $run_query1 = mysqli_query($con, $query1);
    $run_qtysumQuery = mysqli_query($con, $qtysumQuery);
    $row = mysqli_fetch_array($run_qtysumQuery);
    $num_of_days = mysqli_num_rows($run_query1);

    //no of expiring products
    $query2 = "SELECT * FROM stock_expiry WHERE status = 'Near Expiry' OR status = 'Expired'";
    $run_query2 = mysqli_query($con, $query2);
    $num_of_expiring = mysqli_num_rows($run_query2);

    //no of out of stock products
    $query3 = "SELECT * FROM products WHERE status = 'Low Stocks' OR status = 'Out of Stock'";
    $run_query3 = mysqli_query($con, $query3);
    $num_of_low = mysqli_num_rows($run_query3);
    
    //no of transactions
    $run_query4 = mysqli_query($con, $query4);
    $row1 = mysqli_fetch_array($run_query4);
    $num_of_trans = mysqli_num_rows($run_query4);

    //total profit and date created
    $run_query15 = mysqli_query($con, $query15);
    $row15 = mysqli_fetch_array($run_query15);
?>

<div class="w-full min-h-screen mt-20 px-10 pb-4 font-medium">
    <div class="w-full flex flex-col gap-6">
        <div class="w-full rounded-xl h-40 flex flex-col justify-center bg-green-600 text-white p-6 shadow-lg relative overflow-hidden">
            <div class="flex flex-col gap-2 z-10">
                <h1 class="text-2xl font-bold">Hi Admin, Welcome Back!</h1>
                <p class="text-sm opacity-90">In this admin account, you can manage your inventory system efficiently.</p>
            </div>
            <!-- Optional decorative shape or icon -->
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-green-500 rounded-full opacity-30"></div>
        </div>
        <div class="w-full h-40 flex gap-6">
        <!-- Total Products -->
        <div class="w-1/4 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-green-600">
            <div class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-semibold text-lg">Total Products</h1>
                <h1 class="text-4xl text-center text-gray-900 mt-4"><?= number_format($num_of_products, 0)?></h1>
            </div>
            <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
        </div>

        <!-- Average Sales Per Day -->
        <div class="w-1/4 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-blue-600">
            <div class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-semibold text-lg">Average Sales Per Day</h1>
                <h1 class="text-4xl text-center text-gray-900 mt-4"><?= $num_of_days == 0 ? 0 : number_format(($row['grandtotal'] / $num_of_days)) ?></h1>
            </div>
            <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m-6-6V7h6v4" />
                </svg>
            </div>
        </div>

        <!-- Sub-Revenue -->
        <div class="w-1/4 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-yellow-600">
            <div class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-semibold text-lg">Sub-Revenue</h1>
                <h1 class="text-4xl text-center text-gray-900 mt-4">₱ <?= $num_of_trans == 0 ? '0': number_format($row15['prof'], 2, ".", ",")?></h1>
            </div>
            <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 2v2m0 16v2m8-8h2M2 12H0m16.95 5.05l1.414 1.414M4.636 4.636l1.414 1.414M19.364 4.636l-1.414 1.414M6.05 17.364l-1.414 1.414" />
                </svg>
            </div>
        </div>

        <!-- Estimated Revenue -->
        <div class="w-1/4 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-red-600">
            <div class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-semibold text-lg">Estimated Revenue</h1>
                <?php
                    $overhead_EP = 0;

                    if((date('Y-m-d', strtotime($row15['date_created'])) > date('Y-m-d', strtotime('2026-03-30')) && date('Y-m-d', strtotime($row15['date_created'])) < date('Y-m-d', strtotime('2026-04-17')))){
                        $overhead_EP = 3000;
                    }else{
                        $overhead_EP = 3300;
                    }
                ?>
                <h1 class="text-4xl text-center text-gray-900 mt-4">₱ <?= $num_of_trans == 0 ? '0': number_format($row15['prof'] - ($num_of_trans * $overhead_EP), 2)?></h1>
            </div>
            <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

  <div class="w-full h-40 flex gap-6">
    <!-- Expiring Products -->
    <div class="w-1/3 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-yellow-500">
        <div class="flex flex-col gap-2">
            <h1 class="text-gray-700 font-semibold text-lg">Expiring Products</h1>
            <h1 class="text-4xl text-center text-gray-900 mt-4"><?= $num_of_expiring ?></h1>
        </div>
        <div class="flex justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <!-- Low to Zero Stocks -->
    <div class="w-1/3 h-full rounded-xl bg-white shadow-lg p-6 flex flex-col justify-between border-l-4 border-red-500">
        <div class="flex flex-col gap-2">
            <h1 class="text-gray-700 font-semibold text-lg">Low to Zero Stocks</h1>
            <h1 class="text-4xl text-center text-gray-900 mt-4"><?= $num_of_low ?></h1>
        </div>
            <div class="flex justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
        </div>

        <!-- Filter Year -->
        <div class="w-1/3 h-full rounded-xl bg-white shadow-lg p-4 flex flex-col justify-between border-l-4 border-green-500">
            <div class="flex flex-col gap-2">
                <h1 class="text-gray-700 font-semibold text-lg">Filter Year</h1>
                <form action="api/dashboardController.php" method="post" class="flex flex-col gap-2">
                    <select name="year" id="year" class="w-full border h-10 text-lg outline-none px-2 border-gray-300 rounded-lg focus:border-2 focus:border-green-600" required>
                        <option value="">--SELECT--</option>
                        <?php 
                            $query7 = "SELECT YEAR(created_at) as years FROM transactions GROUP BY YEAR(created_at) ORDER BY YEAR(created_at) ASC";
                            $run_query7 = mysqli_query($con, $query7);
                            if(mysqli_num_rows($run_query7) > 0){
                                while($row4 = mysqli_fetch_array($run_query7)){
                                    $filteryear = $row4['years'];
                        ?>
                        <option value="<?= $filteryear ?>"><?= $filteryear ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <div class="flex items-center gap-4 mt-2">
                        <button type="submit" name="filter_year" class="w-1/2 h-10 bg-blue-600 text-white font-semibold hover:bg-blue-700 active:opacity-80 rounded-lg">Filter</button>
                        <a href="dashboard.php" class="w-1/2">
                            <button type="button" class="w-full h-10 bg-gray-600 text-white font-semibold hover:bg-gray-700 active:opacity-80 rounded-lg">Clear</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <div class="w-full h-[30rem] flex gap-6">
            <!-- Sales per Month -->
            <div class="w-[70%] h-full rounded-xl bg-white shadow-lg p-4 flex flex-col gap-4 overflow-y-auto">
                <h1 class="text-xl font-semibold text-gray-700">
                    Sales per Month <span class="text-green-600 font-medium"><?= $year ? $year : 'Overall' ?></span>
                </h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-yellow-600 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Month</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Total Sales</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Sub-Profit</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Estimated Profit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php 
                                if(isset($_GET['year'])){
                                    $query6 = "SELECT MONTH(date_created) as MM, SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions WHERE YEAR(date_created) = '$year' GROUP BY MONTH(date_created) ORDER BY MONTH(date_created) ASC";
                                } else {
                                    $query6 = "SELECT MONTH(date_created) as MM, SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions GROUP BY MONTH(date_created) ORDER BY MONTH(date_created) ASC";
                                }

                                $run_query6 = mysqli_query($con, $query6);

                                if(mysqli_num_rows($run_query6) > 0){
                                    while($row3 = mysqli_fetch_array($run_query6)){
                                        $month_name = date("F", mktime(0, 0, 0, $row3['MM'], 1));
                                        $MM = $row3['MM'];
                                        $date_created = $row3['date_created'];
                                        $date_ymd = date('Y-m-d', strtotime($date_created));

                                        // Count the number of transaction days for estimated profit
                                        if(isset($_GET['year'])){
                                            $query8 = "SELECT * FROM transactions WHERE MONTH(date_created) = '$MM' AND YEAR(date_created) = '$year' GROUP BY date_created";
                                        } else {
                                            $query8 = "SELECT * FROM transactions WHERE MONTH(date_created) = '$MM' GROUP BY date_created";
                                        }
                                        $run_query8 = mysqli_query($con, $query8);
                                        $num_days = mysqli_num_rows($run_query8);
        
                                    ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-3"><?= $month_name ?></td>
                                        <td class="px-4 py-3 font-medium">₱<?= number_format($row3['Total'], 2, '.', ',') ?></td>
                                        <td class="px-4 py-3 font-medium">₱<?= number_format($row3['Subprofit'], 2, '.', ',') ?> 
                                            (<?= number_format(($row3['Subprofit'] / $row3['Total']) * 100, 2) ?>%)
                                        </td>
                                        <?php
                                            $overhead_Sales_Monthly = 0;

                                            if(($date_ymd > date('Y-m-d', strtotime('2026-03-30'))) && ($date_ymd < date('Y-m-d', strtotime('2026-04-17')))){
                                                $overhead_Sales_Monthly = 3000;
                                            }else if(($date_ymd > date('Y-m-d', strtotime('2026-04-17'))) && ($date_ymd < date('Y-m-d', strtotime('2026-08-30')))){
                                                $overhead_Sales_Monthly = 3300;
                                            }else if(($date_ymd > date('Y-m-d', strtotime('2026-08-30')))){
                                                $overhead_Sales_Monthly = 3000;
                                            }else{
                                                $overhead_Sales_Monthly = 3000; 
                                            }
                                        ?>
                                        <td class="px-4 py-3 font-medium">₱<?= number_format($row3['Subprofit'] - ($num_days * $overhead_Sales_Monthly), 2, ".", ",")?></td>
                                    </tr>
                                    <?php
                                    }
                                } else {
                            ?>
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500 font-medium">No Sales Found!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- best selling -->
            <div class="w-[30%] h-full rounded-xl bg-white shadow-lg p-4 flex flex-col gap-4 overflow-y-auto">
                <h1 class="text-xl font-semibold text-gray-700">Top 10 Best Selling Products</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Product Name</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Units Sold</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php 
                                $query9 = "";
                                if(isset($_GET['year']) && !empty($_GET['year'])){
                                    $query9 = "SELECT products.name, SUM(productsold.qty) as QTY 
                                            FROM productsold 
                                            JOIN products ON productsold.productId = products.productId 
                                            WHERE YEAR(productsold.date_created) = '$year' 
                                            GROUP BY productsold.productId 
                                            ORDER BY SUM(productsold.qty) DESC 
                                            LIMIT 10";
                                } else {
                                    $query9 = "SELECT products.name, SUM(productsold.qty) as QTY 
                                            FROM productsold 
                                            JOIN products ON productsold.productId = products.productId 
                                            GROUP BY productsold.productId 
                                            ORDER BY SUM(productsold.qty) DESC 
                                            LIMIT 10";
                                }

                                $run_query9 = mysqli_query($con, $query9);

                                if(mysqli_num_rows($run_query9) > 0){
                                    while($row5 = mysqli_fetch_array($run_query9)){
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 font-medium"><?= $row5['name'] ?></td>
                                <td class="px-4 py-3 font-medium">
                                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800"><?= number_format($row5['QTY']) ?> sold</span>
                                </td>
                            </tr>
                            <?php
                                    }
                                } else {  
                            ?>
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-center text-gray-500 font-medium">No Products Found!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales Last 50 Day -->
            <div class="w-full h-[30rem] rounded-xl bg-white shadow-lg p-6 flex flex-col gap-4 overflow-y-auto">
                <h1 class="text-xl font-semibold text-gray-700">Sales Last 100 Days</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-600 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Date</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Total Sales</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Sub-Profit</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Estimated Profit</th>
                                <th class="px-4 py-3 text-left font-semibold text-white uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php 
                               $query5 = "SELECT SUM(total) as Total, SUM(profit) as Subprofit, date_created FROM transactions GROUP BY date_created ORDER BY date_created DESC LIMIT 100 ";
                                $run_query5 = mysqli_query($con, $query5);

                                if(mysqli_num_rows($run_query5) > 0){
                                    while($row2 = mysqli_fetch_array($run_query5)){
                                        $date = date('F j, Y - l', strtotime($row2['date_created']));

                                        $overhead_Sales = 0;

                                        if((date('Y-m-d', strtotime($row2['date_created'])) > date('Y-m-d', strtotime('2026-03-30'))) && (date('Y-m-d', strtotime($row2['date_created'])) < date('Y-m-d', strtotime('2026-04-17')))){
                                            $overhead_Sales = 3000;
                                        }else if((date('Y-m-d', strtotime($row2['date_created'])) > date('Y-m-d', strtotime('2026-04-17'))) && (date('Y-m-d', strtotime($row2['date_created'])) < date('Y-m-d', strtotime('2026-08-30')))){
                                                $overhead_Sales = 3300;
                                        }else if((date('Y-m-d', strtotime($row2['date_created'])) > date('Y-m-d', strtotime('2026-08-30')))){
                                            $overhead_Sales = 3000;
                                        }else{
                                            $overhead_Sales = 3300;
                                        }
                                        $estimated = $row2['Subprofit'] - $overhead_Sales;
                                        $status_class = $estimated < 1 ? 'text-red-600 bg-red-100' : 'text-green-600 bg-green-100';
                                        $status_text = $estimated < 1 ? 'Loss' : 'Gain';
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3"><?= $date ?></td>
                                <td class="px-4 py-3 font-medium">₱<?= number_format($row2['Total'], 2, ".", ",") ?></td>

                                <td class="px-4 py-3 font-medium">₱<?= number_format($row2['Subprofit'], 2, ".", ",") ?> 
                                    (<?= number_format(($row2['Subprofit'] / $row2['Total']) * 100, 2) ?>%)
                                </td>

                                <td class="px-4 py-3 text-sm font-medium">₱<?= number_format($estimated, 2, ".", ",") ?></td>

                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $status_class ?>"><?= $status_text ?></span>
                                </td>

                            </tr>
                            <?php
                                    }
                                } else {
                            ?>
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500 font-medium">No Sales Found!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>

<?php include 'partials/__footer.php';?>