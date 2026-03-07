<?php 
session_start();
$title = "Napsan Pharmacy || Stocks History";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/alerts.php';
require 'popups/delStocks.php';

?>
    <div class="w-full h-screen pt-10 p-2">
        <div class="w-full h-full bg-white shadow-md rounded-sm p-4 flex flex-col gap-4">
            <div class="w-full h-10rem flex justify-between">
                <div class="w-auto h-auto flex items-center font-medium">
                    <a href="inventory.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Products Inventory</a>
                    <a href="stocks.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 border-green-600 bg-slate-100">Stocks Deliveries</a>
                    <a href="low_stock.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Low Stocks</a>
                    <a href="expiring.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Expiring Products</a>
                    <?php if($_SESSION['user']['role'] == 'admin'){?>
                        <button class="delAll ml-2 px-2 py-1 rounded-sm bg-red-600 font-medium text-white hover:bg-red-700 active:opacity-80">Delete All</button>
                    <?php }?>
                </div>

                <div class="w-2/5 h-10 bg-slate-100 flex items-center gap-2 px-2 rounded-sm hover:bg-slate-200">
                    <input type="text" class="w-11/12 outline-none py-1 bg-slate-100 focus:border-b-2 focus:border-green-600 px-2" placeholder="search here..." autofocus id="myInput" onkeyup="myFunction()">
                    <img src="imgs/search.png" alt="" class="w-7">
                </div>
            </div>  

            <div class="w-full h-[90%] overflow-y-auto">
                <table class="w-full font-medium" id="myTable">
                    <thead>
                        <tr class="border-y bg-green-600 text-white">
                            <th class="p-1 text-left">Date Inputted</th>
                            <th class="p-1 text-left">Product Name</th>
                            <th class="p-1 text-left">Stocks In</th>   
                            <th class="p-1 text-left">Expiry</th>
                            <th class="p-1 text-left">Distributor</th>
                            <th class="p-1 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(isset($_GET['page'])){
                                    $page = mysqli_real_escape_string($con, $_GET['page']);
                                    $currPage = 0;
                                    $currPage = $currPage + $page;
                                    $offset = $currPage * 20;
                                    $query = "SELECT stock_expiry.*, products.*, stock_expiry.created_at as del_date FROM stock_expiry JOIN products ON stock_expiry.productId = products.productId ORDER BY stock_expiry.created_at DESC LIMIT 20 OFFSET $offset";
                            }else{
                                    $query = "SELECT stock_expiry.*, products.*, stock_expiry.created_at as del_date FROM stock_expiry JOIN products ON stock_expiry.productId = products.productId ORDER BY stock_expiry.created_at DESC LIMIT 20";
                            }
                        
                            $run_query = mysqli_query($con, $query);
                            $num_rows = mysqli_num_rows($run_query);
                            if($num_rows > 0){
                                while($row = mysqli_fetch_array($run_query)){
                        ?>
                        <tr class="border-b border-slate-400 hover:bg-slate-100">
                            <?php 
                                $date1 = $row['del_date'];
                                $date1 = date("F j, Y", strtotime($date1));

                                $expiry = $row['expiry'];
                                $expiry = date("F j, Y", strtotime($expiry));

                            ?>
                            <td class="p-1"><?= $date1?></td>
                            <td class="p-1 text-sm"><?= $row['name']?></td>
                            <td class="p-1"><?= $row['stocks_in']?></td>        
                            <td class="p-1"><?= $expiry?></td>
                            <td class="p-1"><?= $row['distributor']?></td>
                            <td class="p-1">
                                <button type="button" onclick="openEdit(<?= $row['stId']?>)" class="text-xs p-1 rounded-sm bg-blue-600 hover:bg-blue-700  text-white active:opacity-80">Edit</button>
                                <?php require 'popups/editStock.php';?>
                            </td>
                        </tr> 
                        
                        <?php 
                                }}else{
                        ?>
                            <tr class="text-center">
                                <td colspan="7" class="p-1 font-medium">No Stock Deliveries Conducted!</td>
                            </tr>
                        <?php
                                }
                        ?>
                    </tbody>
                </table>
                
                <div class="w-full h-auto flex items-center justify-end py-4 px-2 gap-2">
                    <a href="stocks.php?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : -1;?>" class="<?= $currPage == 0 ? 'hidden' : ''?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">< Previous</button></a>
                    <a href="stocks.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : 1;?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">Next ></button></a>
                </div>
             
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


    function openEdit(n){    
        const editStock = document.querySelector(".editStock" + n);
        if (editStock) {
            editStock.classList.replace('hidden', 'flex');
        }
    }

    function closeEdit(n){
        const editStock = document.querySelector(".editStock" + n);
        if (editStock) {
            editStock.classList.replace('flex', 'hidden');
        }
    }
</script>

<?php include 'partials/__footer.php';?>