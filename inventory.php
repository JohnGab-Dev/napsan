<?php 
session_start();
$title = "Napsan Pharmacy || Inventory";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/addProd.php';
require 'popups/alerts.php';
require 'methods/checkInvent.php';
?>
    <div class="w-full h-screen pt-10 p-2">
        <div class="w-full h-full bg-white shadow-md rounded-sm p-4 flex flex-col gap-4">
            <div class="w-full h-10rem flex justify-between">
                <div class="w-auto h-auto flex items-center font-medium">
                    <a href="inventory.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 border-green-600 bg-slate-100">Products Inventory</a>
                    <a href="stocks.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Stocks Del</a>
                    <a href="low_stock.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Low Stocks</a>
                    <a href="expiring.php" class="px-2 hover:bg-slate-100 py-1 border-b-2 ">Expiring Products</a>

                    <button type="button" class="add flex items-center gap-2 ml-2 px-2 py-1 bg-green-600 text-white rounded-sm hover:bg-green-700 active:opacity-80">Add New Product</button>
                </div>

            <form action="api/searchController.php" method="post" class="w-2/5 flex items-center">
                <div class="w-4/5 h-10 bg-slate-100 flex items-center gap-2 px-2 rounded-sm hover:bg-slate-200">
                    <input type="text" name="search" class="w-11/12 outline-none py-1 bg-slate-100 focus:border-b-2 focus:border-green-600 px-2" placeholder="search here..." autofocus id="myInput" onkeyup="myFunction()">
                    <img src="imgs/search.png" alt="" class="w-7">
                </div>
                <button type="submit" name="findProd" class="text-base h-10 w-2/12 p-1 rounded-sm bg-green-600 hover:bg-green-700 text-white active:opacity-80 font-medium">Search</button>
                
            </form>
                
            </div>  

            <div class="w-full h-[90%] overflow-y-auto">
                <table class="w-full font-medium" id="myTable">
                    <thead>
                        <tr class="border-y bg-green-600 text-white">
                            
                            <th class="p-1 text-left">Product Name</th>
                            <th class="p-1 text-left">Stocks</th>
                            <th class="p-1 text-left">SRP</th> 
                            <th class="p-1 text-left">Capital</th> 
                            <th class="p-1 text-left">Distributor</th>
                            <th class="p-1 text-left">Status</th>
                            <th class="p-1 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!isset($_GET['search'])){
                                if(isset($_GET['page'])){
                                    $page = mysqli_real_escape_string($con, $_GET['page']);
                                    $currPage = 0;
                                    $currPage = $currPage + $page;
                                    $offset = $currPage * 20;
                                    $query = "SELECT * FROM products ORDER BY name ASC LIMIT 20 OFFSET $offset";
                                }else{
                                    $query = "SELECT * FROM products ORDER BY name ASC LIMIT 20";
                                }
                            }else{
                                $search = mysqli_real_escape_string($con, $_GET['search']);
                                $query = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY name ASC";
                            }
                            $run_query = mysqli_query($con, $query);
                            $num_of_rows = mysqli_num_rows($run_query);
                            if($num_of_rows>0){
                                while($row = mysqli_fetch_array($run_query)){
                                    
                        ?>
                        
                        <tr class="border-b border-slate-400 hover:bg-slate-100">
                            <td class="p-1 text-sm"><?= $row['name']?></td>
                            <td class="p-1"><?= $row['qty']?></td>
                            <td class="p-1"><?= $row['srp']?></td>
                            <td class="p-1"><?= $row['capital']?></td>
                            <td class="p-1"><?= $row['distributor']?></td>
                            <?php 
                                if($row['status'] == 'Good'){
                                    $color = 'bg-green-200';
                                }else if($row['status'] == 'Low Stocks'){
                                    $color = 'bg-yellow-200';
                                }else if($row['status'] == 'hidden'){
                                    $color = 'bg-neutral-200';
                                }else{
                                    $color = 'bg-red-200';
                                } 
                            ?>
                            <td class="p-1"><span class="px-2 <?= $color?> rounded-sm text-sm"><?= $row['status']?></span></td>
                            <td class="p-1 flex items-center gap-2">
                                <button type="button" onclick="openAdd(<?= $row['productId'];?>)" type="button" class="text-xs p-1 rounded-sm bg-green-600 hover:bg-green-700 text-white active:opacity-80">Add</button>
                                <?php require 'popups/addStock.php';?>
                                <button type="button" onclick="editProd(<?= $row['productId']?>)" class="text-xs p-1 rounded-sm bg-blue-600 hover:bg-blue-700  text-white active:opacity-80">Edit</button>
                                <?php require 'popups/editProd.php';?>
                                <?php if($_SESSION['user']['role'] == 'admin'){?>
                                    <button type="button" onclick="warnDel(<?= $row['productId']?>)" class="text-xs p-1 rounded-sm bg-red-600 hover:bg-red-700  text-white active:opacity-80">Del</button>
                                    <?php require 'popups/warnDel.php';?>
                                <?php }?>
                                
                                <form action="api/ProductController.php?id=<?= $row['productId']?>" method="post">
                                    <?php  if($row['status'] != 'hidden'){?>
                                    <button type="submit" name="hide" class="text-xs p-1 rounded-sm bg-amber-600 hover:bg-amber-700 text-white active:opacity-80">Hide</button>
                                    <?php }else{?>
                                    <button type="submit" name="unhide" class="text-xs p-1 rounded-sm bg-neutral-600 hover:bg-neutral-700 text-white active:opacity-80">Unhide</button>
                                    <?php }?>
                                </form>
                                
                            </td>
                            
                        </tr>
                    <?php }}else{?>
                        <tr class="text-center">
                            <td colspan="7" class="p-1 font-medium">No Products Found!</td>
                        </tr>
                    <?php }?> 
                    </tbody>
                </table>
                <?php if(!isset($_GET['search'])){?>
                <div class="w-full h-auto flex items-center justify-end py-4 px-2 gap-2">
                    <a href="inventory.php?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : -1;?>" class="<?= $currPage == 0 ? 'hidden' : ''?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">< Previous</button></a>
                    <a href="inventory.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : 1;?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">Next ></button></a>
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

    function openAdd(n){
        const addStock = document.querySelector(".addStock" + n);
        if (addStock) {
            addStock.classList.replace('hidden', 'flex');
        }
    }

    function closeAdd(n){
        const addStock = document.querySelector(".addStock" + n);
        if (addStock) {
            addStock.classList.replace('flex', 'hidden');
        }
    } 

    function warnDel(n){
        const delProd = document.querySelector(".delProd" + n);
        if (delProd) {
            delProd.classList.replace('hidden', 'flex');
        }
    }

    function closeDel(n){    
        const delProd = document.querySelector(".delProd" + n);
        if (delProd) {
            delProd.classList.replace('flex', 'hidden');
        }
    }


    function editProd(n){
        const editProd = document.querySelector(".editProd" + n);
        if (editProd) {
            editProd.classList.replace('hidden', 'flex');
        }
    }

    function closeEdit(n){    
        const editProd = document.querySelector(".editProd" + n);
        if (editProd) {
            editProd.classList.replace('flex', 'hidden');
        }
    }
    

    
</script>

<?php include 'partials/__footer.php';?>