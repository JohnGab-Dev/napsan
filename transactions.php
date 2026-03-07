<?php 
session_start();
$title = "Napsan Pharmacy || Transaction Today";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/alerts.php';

?>
    <div class="w-full h-screen pt-10 p-2">
        <div class="w-full h-full bg-white shadow-md rounded-sm p-4 flex flex-col gap-4">
            <div class="w-full h-10rem flex justify-between">
                <div class="w-auto h-auto flex items-center font-medium">
                    <a href="transactions.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 border-green-600 bg-slate-100">Transactions Today</a>
                    <a href="tr_history.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Transaction History</a>
                </div>

                <div class="w-2/5 h-10 bg-slate-100 flex items-center gap-2 px-2 rounded-sm hover:bg-slate-200">
                    <input type="text" class="w-11/12 outline-none py-1 bg-slate-100 focus:border-b-2 focus:border-green-600 px-2" placeholder="search here..." autofocus id="myInput" onkeyup="myFunction()">
                    <img src="imgs/search.png" alt="" class="w-7">
                </div>
            </div>  

            <div class="w-full h-[80%] overflow-y-auto">
                <table class="w-full font-medium" id="myTable">
                    <thead>
                        <tr class="border-y bg-green-600 text-white">
                            <th class="p-1 text-left">Transaction No.</th>
                            <th class="p-1 text-left">Sub-Total</th>
                            <th class="p-1 text-left">Discount</th>
                            <th class="p-1 text-left">Total</th>
                            <?php if($_SESSION['user']['role'] == 'admin'){?>
                            <th class="p-1 text-left">Profit</th>
                            <?php }?>
                            <th class="p-1 text-left">Mode of Payment </th>    
                            <th class="p-1 text-left">Reference Num </th>
                            <th class="p-1 text-left">Time Processed </th>
                            <th class="p-1 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $date = date("Y-m-d");
                            $date = date("Y-m-d", strtotime($date));
                            $query = "SELECT * FROM transactions WHERE date_created = '$date' ORDER BY created_at DESC";
                            $run_query = mysqli_query($con, $query);
                            $total = 0;
                            $gcash = 0;
                            $cash = 0;
                            $profit = 0;

                            if(mysqli_num_rows($run_query)>0){
                                while($row = mysqli_fetch_array($run_query)){
                                    $trTime = $row['created_at'];
                                    $trTime = date("h:i:s A", strtotime($trTime));

                                    $total = $total + $row['total'];
                                    $profit = $profit + $row['profit'];
                                    if($row['mode_of_payment'] == 'Cash'){
                                        $cash = $cash + $row['total'];
                                    }else if($row['mode_of_payment'] == 'Gcash'){
                                        $gcash = $gcash + $row['total'];
                                    }

                        ?>
                        <tr class="border-b border-slate-400 hover:bg-slate-100">
                            <td class="p-1 text-sm"><?= $row['transId']?></td>
                            <td class="p-1">P<?= $row['subtotal']?></td>
                            <td class="p-1">P<?= $row['discount']?></td>
                            <td class="p-1">P<?= $row['total']?></td>
                            <?php if($_SESSION['user']['role'] == 'admin'){?>
                            <td class="p-1">P<?= $row['profit']?></td>
                            <?php }?>
                            <td class="p-1"><?= $row['mode_of_payment']?></td>
                            <td class="p-1">
                                <?= $row['ref_num']?>
                            </td>
                            <td class="p-1 text-left"><?= $trTime;?> </td>
                            <td class="p-1 flex items-center gap-1">
                                <a href="receipt.php?id=<?= $row['transId']?>"><button type="button" class="text-xs p-1 rounded-sm bg-yellow-600 hover:bg-yellow-700  text-white active:opacity-80">View</button></a>
                                <a href="editTr.php?id=<?= $row['transId']?>"><button type="button" class="text-xs p-1 rounded-sm bg-blue-600 hover:bg-blue-700  text-white active:opacity-80">Edit</button></a>
                                <?php if($_SESSION['user']['role'] == 'admin'){?>
                                <form action="api/TransactionController.php?id=<?= $row['transId']?>" method="post">
                                    <button type="submit" name="delTr" class="text-xs p-1 rounded-sm bg-red-600 hover:bg-red-700  text-white active:opacity-80">Del</button>
                                </form>
                                <?php }?>
                                
                            </td>
                        </tr> 
                        <?php
                                }
                            }else{
                            ?>
                            <tr class="text-center">
                                <td colspan="9" class="p-1 font-medium">No Transactions Found!</td>
                            </tr>
                        <?php } ?> 
                        
                    </tbody>
                </table>
            </div>
            <div class="w-full h-[10%] flex justify-between gap-4">

                <div class="w-1/5 h-full flex font-medium rounded-sm p-2 gap-4">
                    <?php 
                        date_default_timezone_set("Asia/Manila");
                        ?>
                    <h1 class="text-lg">Total sales this day: <br> <?= date("F j, Y");?></h1>
                    
                </div>

                
                <div class="w-1/5 h-full flex font-medium rounded-sm p-2 gap-4 bg-white border border-r-4 border-blue-600 shadow-md">
                    <h1 class="text-sm">Gcash Sales:</h1>
                    <p class="text-2xl">P<?= number_format($gcash, 2)?></p>
                </div>

                <div class="w-1/5 h-full flex font-medium rounded-sm p-2 gap-4 bg-white border border-r-4 border-yellow-600 shadow-md">
                    <h1 class="text-sm">Cash Sales:</h1>
                    <p class="text-2xl">P<?= number_format($cash, 2)?></p>
                </div>
                <div class="w-1/5 h-full flex font-medium rounded-sm p-2 gap-4 bg-white border border-r-4 border-green-600 shadow-md"> 
                    <h1 class="text-sm">Total Sales:</h1>
                    <p class="text-2xl">P<?= number_format($total, 2)?></p>
                </div>
                <?php if($_SESSION['user']['role'] == 'admin'){?>
                <div class="w-1/5 h-full flex font-medium rounded-sm p-2 gap-4 bg-white border border-r-4 border-red-600 shadow-md">
                    <h1 class="text-sm">Profit:</h1>
                    <p class="text-2xl">P<?= number_format($profit, 2)?></p>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Start from i = 1 to skip the header row
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    let rowContainsFilter = false;

    for (j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          rowContainsFilter = true;
          break;
        }
      }
    }

    tr[i].style.display = rowContainsFilter ? "" : "none";
  }
}
</script>

<?php include 'partials/__footer.php';?>