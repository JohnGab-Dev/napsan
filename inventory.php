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
    <div class="w-full h-screen pt-20 px-4 pb-4">
        <div class="w-full h-full bg-white shadow-lg rounded-lg p-6 flex flex-col gap-4">
            <div class="w-full h-10rem flex justify-between">
                <div class="flex flex-wrap items-center gap-2 font-medium">

                <!-- Tabs -->
                <a href="inventory.php" class="px-4 py-2 rounded-t-md border-b-2 border-green-600 bg-green-50 text-green-800 hover:bg-green-100 transition">
                    Products Inventory
                </a>
                <a href="stocks.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                    Stocks Del
                </a>
                <a href="low_stock.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                    Low Stocks
                </a>
                <a href="expiring.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                    Expiring Products
                </a>

                <!-- Add Button -->
                <button type="button" onclick="openModal()" class="add ml-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 active:opacity-80 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Product
                </button>

            </div>

            <form action="api/searchController.php" method="post" class="w-2/5 flex items-center">
                <!-- Search Container -->
                    <div class="relative w-full">
                        <!-- Search Icon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>
                        </div>

                        <!-- Input -->
                        <input 
                            type="text" 
                            name="search" 
                            id="myInput" 
                            onkeyup="myFunction()" 
                            placeholder="Search products..." 
                            autofocus
                            class="w-full rounded-xl bg-gray-100 pl-10 pr-4 py-3 text-gray-700 placeholder-gray-400 shadow-sm focus:bg-white focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                        >

                        <!-- Submit Button -->
                        <button type="submit" name="findProd" class="absolute right-0 top-0 h-full px-6 bg-green-600 rounded-r-xl text-white font-semibold hover:bg-green-700 transition">
                            Search
                        </button>
                    </div>
            </form>
                
            </div>  

            <div class="w-full h-[90%] overflow-y-auto">
                <div class="w-full">
                    <table id="myTable" class="w-full text-left border-collapse">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                <th class="p-3 rounded-tl-lg">Product Name</th>
                                <th class="p-3">Stocks</th>
                                <th class="p-3">SRP</th>
                                <th class="p-3">Capital</th>
                                <th class="p-3">Distributor</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 rounded-tr-lg">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
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
                                    if($row['status'] == 'Good'){
                                        $color = 'bg-green-200 text-green-800';
                                    } else if($row['status'] == 'Low Stocks'){
                                        $color = 'bg-yellow-200 text-yellow-800';
                                    } else if($row['status'] == 'hidden'){
                                        $color = 'bg-gray-200 text-gray-800';
                                    } else {
                                        $color = 'bg-red-200 text-red-800';
                                    }
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-2 font-medium"><?= $row['name']?></td>
                                <td class="p-2"><?= $row['qty']?></td>
                                <td class="p-2"><?= $row['srp']?></td>
                                <td class="p-2"><?= $row['capital']?></td>
                                <td class="p-2"><?= $row['distributor']?></td>
                                <td class="p-2">
                                    <span class="px-2 py-1 rounded-full text-xs <?= $color ?>"><?= $row['status']?></span>
                                </td>
                                <td class="p-2 flex flex-wrap gap-2">
                                    <button type="button" onclick="openAdd(<?= $row['productId'];?>)" class="text-xs px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md transition">Add</button>
                                    <?php require 'popups/addStock.php';?>
                                    <button type="button" onclick="editProd(<?= $row['productId']?>)" class="text-xs px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">Edit</button>
                                    <?php require 'popups/editProd.php';?>
                                    <?php if($_SESSION['user']['role'] == 'superadmin'){ ?>
                                        <button type="button" onclick="warnDel(<?= $row['productId']?>)" class="text-xs px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md transition">Del</button>
                                        <?php require 'popups/warnDel.php';?>
                                    <?php } ?>
                                    <form action="api/ProductController.php?id=<?= $row['productId']?>" method="post">
                                        <?php if($row['status'] != 'hidden'){ ?>
                                            <button type="submit" name="hide" class="text-xs px-2 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded-md transition">Hide</button>
                                        <?php }else{ ?>
                                            <button type="submit" name="unhide" class="text-xs px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition">Unhide</button>
                                        <?php } ?>
                                    </form>
                                </td>
                            </tr>
                            <?php }} else { ?>
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500 font-medium">No Products Found!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php 

                     $query1 = "SELECT * FROM products";
                     $run_query1 = mysqli_query($con, $query1);
                    if(!isset($_GET['search']) &&  mysqli_num_rows($run_query1)>20){
                ?>
                <div class="w-full h-auto flex items-center justify-end py-4 px-2 gap-2">
                    <a href="inventory.php?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : -1;?>" class="<?= $currPage == 0 ? 'hidden' : ''?>">
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 transition font-medium active:opacity-80">&lt; Previous</button>
                    </a>
                    <a href="inventory.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : 1;?>">
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 transition font-medium active:opacity-80">Next &gt;</button>
                    </a>
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