<?php 
session_start();
$title = "Napsan Pharmacy || POS";
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


?>
    <div class="w-full h-screen pt-10 p-2 flex gap-2">
        <div class="w-1/2 h-full bg-white p-4">
            <h1 class="font-semibold">SELECT ITEMS HERE</h1>
            <form action="api/searchController.php" method="post" class="w-full flex items-center">
                <div class="w-10/12 h-12 bg-slate-100 flex items-center gap-2 px-2 rounded-sm hover:bg-slate-200">
                    <input type="text" name="search" class="w-11/12 outline-none py-1 bg-slate-100 focus:border-b-2 focus:border-green-600 px-2" placeholder="search here..." autofocus id="myInput" onkeyup="myFunction()">
                    <img src="imgs/search.png" alt="" class="w-7">
                </div>
                <button type="submit" name="find" class="text-base h-12 w-2/12 p-1 rounded-sm bg-green-600 hover:bg-green-700 text-white active:opacity-80 font-medium">Search</button>
            </form>
            <div class="w-full px-2 py-2"></div>

            <div class="w-full h-[83%] overflow-y-auto">
                <table class="w-full font-medium" id="myTable">
                    <thead>
                        <tr class="text-white bg-green-600">
                            <th class="p-1 text-left">Product Name</th>
                            <th class="p-1 text-left">Stock </th>
                            <th class="p-1 text-left">SRP </th>
                            <th class="p-1 text-left">QTY </th>
                            <th class="p-1 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['search'])){
                            $search = mysqli_real_escape_string($con, $_GET['search']);
                            $query = "SELECT * FROM products WHERE name LIKE '%$search%'";
                            $run_query = mysqli_query($con, $query);
                            if(mysqli_num_rows($run_query)>0){
                                while($row = mysqli_fetch_array($run_query)){

                        ?>
                        <tr class="border-b border-slate-400 hover:bg-slate-100">
                            <td class="p-1 text-sm"><?= $row['name']?></td>
                            <td class="p-1"><?= $row['qty']?></td>
                            <td class="p-1"><?= $row['srp']?></td>
                            <td class="p-1">
                                <form action="api/POSController.php?id=<?= $row['productId']?>" method="post">
                                    <input type="number" name="qty" class="outline-none border rounded-sm w-20 h-7 border-black px-1 focus:border-2 focus:border-green-600" placeholder="QTY" required>
                            </td>
                            <td class="p-1">
                                <button type="submit" name="addtocart" class="text-xs p-1 rounded-sm bg-blue-500 hover:bg-blue-600  text-white active:opacity-80">Add to Cart</button>
                                </form>
                            </td>
                        </tr> 
                        <?php
                                }
                            }else{
                        ?>
                        <tr class="text-center">
                            <td colspan="5" class="p-1 font-medium">No Products Found!</td>
                        </tr>
                    <?php }}else{?> 
                        <tr class="text-center">
                            <td colspan="5" class="p-1 font-medium">Search For Products First</td>
                        </tr>
                    <?php }?>
                        
                            
                            
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="w-1/2 h-full bg-white flex flex-col gap-4 overflow-y-auto">
            <div class="w-full h-1/2 border-b p-4">
                <div class="w-full h-auto py-1 bg-white">
                    <h1 class="font-semibold">CART</h1>
                </div>

                <div class="w-full h-[90%] overflow-y-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-white bg-green-600">
                                <th class="p-1 text-left">Product Name </th>
                                <th class="p-1 text-left">QTY </th>
                                <th class="p-1 text-left">SRP </th>
                                <th class="p-1 text-left">Total </th>
                                <th class="p-1 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium">

                        <?php

                            $query1 = "SELECT cart.cartId, cart.productId, cart.qty as Cqty, cart.srp, cart.capital, cart.total, products.name FROM cart JOIN products ON cart.productId = products.productId ORDER BY cart.created_at DESC";
                            $run_query1 = mysqli_query($con, $query1);
                            $sub_total = 0;

                            if(mysqli_num_rows($run_query1)>0){
                                while($row1 = mysqli_fetch_array($run_query1)){
                                    $sub_total = $sub_total + $row1['total'];
                        ?>
                            
                            <tr class="border-b border-slate-400 hover:bg-slate-100">
                                <td class="p-1"><?= $row1['name']?></td>
                                <td class="p-1"><?= $row1['Cqty']?></td>
                                <td class="p-1">P<?= $row1['srp']?></td>
                                <td class="p-1">
                                    P<?= $row1['total']?>
                                </td>
                                <td class="p-1 flex items-center gap-1">
                                    
                                    <button type="button" onclick="editCart(<?= $row1['cartId']?>)" class="text-xs p-1 rounded-sm bg-blue-600 hover:bg-blue-700 text-white active:opacity-80">Edit</button>
                                   <?php require 'popups/editCart.php';?>
                                    
                                    <form action="api/POSController.php?id=<?= $row1['cartId'];?>" method="post">
                                        <button type="submit" name="delCart" class="text-xs p-1 rounded-sm bg-red-600 hover:bg-red-700 text-white active:opacity-80">Del</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            }else{
                        ?>
                        <tr class="text-center">
                            <td colspan="5" class="p-1 font-medium py-1">No Products added</td>
                        </tr>
                    <?php }?> 
                            
                        </tbody>
                    </table>

                </div>
                
                
            </div>
            <form action="api/POSController.php" method="post" class="w-full h-1/2 flex flex-col px-4 gap-2">
                <div class="w-full h-auto flex justify-between items-center">
                    <label for="" class="font-semibold">SUB-TOTAL(PHP):</label>
                    <input type="text" step="any" name="subtotal" class="sub text-right py-1 outline-none w-4/6 border font-medium mr-12 bg-slate-100 px-2" readonly value="<?= number_format($sub_total, 2);?>" required>
                </div>

                <div class="w-full h-auto flex justify-between items-center gap-2">
                    <label for="" class="font-semibold">DISCOUNT(PHP):</label>
                    <input type="number" step="any" name="discount" class="dis border border-black rounded-sm px-2 py-1 outline-none w-4/5 h-8 font-medium mr-12 focus:border-2 focus:border-green-600" value="0">
                </div>

                <div class="w-full h-auto flex justify-between items-center">
                    <label for="" class="font-semibold">TOTAL(PHP):</label>
                    <input type="text" step="any" name="total" class="total text-right py-1 outline-none w-4/6 border font-medium mr-12 bg-slate-100 px-2" readonly value="<?= number_format($sub_total, 2);?>" required>
                </div>

                <div class="w-full h-auto flex items-center gap-2">
                    <h1 class="font-medium">Payment Methods:</h1>
                    <input type="radio" name="methods" class="hidden" id="method1" required value="Cash">
                    <label for="method1" class="method px-2 py-1 border rounded-sm hover:bg-green-100 cursor-pointer font-medium" id="method1" >CASH</label>

                    <input type="radio" name="methods" class="hidden" id="method2" required value="Gcash">
                    <label for="method2" class="method px-2 py-1 border rounded-sm hover:bg-green-100 cursor-pointer font-medium" id="method2" >G-CASH</label>

                    <input type="number" name="refnum" class="border border-black rounded-sm px-2 py-1 outline-none w-[13.5rem] h-8 font-medium mr-12 focus:border-2 focus:border-green-600" placeholder="Ref. num(if gcash)">
                </div>

                <div class="w-full h-auto flex justify-between items-center gap-2">
                    <label for=""  class="font-semibold">AMOUNT TENDERED(PHP):</label>
                    <input type="number" step="any" name="amount" class="border border-black rounded-sm px-2 py-1 outline-none w-4/5 h-8 font-medium mr-12 focus:border-2 focus:border-green-600" value="" placeholder="0.00" required>
                </div>
                

                <div class="w-full h-auto flex justify-end items-center gap-4">
                    
                    <button type="submit" name="checkout" class="px-2 py-2 rounded-sm bg-green-600 hover:bg-green-700 text-white font-medium active:opacity-80">Checkout</button>
                    <button type="submit" name="abort" class="px-2 py-2 rounded-sm bg-neutral-600 hover:bg-neutral-700  text-white font-medium active:opacity-80">Cancel</button>
                </div>
            </form>
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

document.addEventListener("DOMContentLoaded", () => {
    function parseFormattedNumber(value) {
        // Remove commas then convert to float
        return parseFloat(value.replace(/,/g, '')) || 0;
    }
    function formatNumber(value) {
        // Format number with 2 decimals and comma
        return value.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    const sub = document.querySelector(".sub");
    const dis = document.querySelector(".dis");
    const total = document.querySelector(".total");

    function updateTotal() {
        const subValue = parseFormattedNumber(sub.value) || 0;
        const disValue = parseFormattedNumber(dis.value) || 0;
        const newTotal = subValue - disValue;
        total.value = formatNumber(newTotal);
    }

    sub.addEventListener("input", updateTotal);
    dis.addEventListener("input", updateTotal);
});

    function editCart(n){
        const editCart = document.querySelector(".editCart" + n);
        if (editCart) {
            editCart.classList.replace('hidden', 'flex');
        }
    }

    function closeEdit(n){    
        const editCart = document.querySelector(".editCart" + n);
        if (editCart) {
            editCart.classList.replace('flex', 'hidden');
        }
    }
</script>

<?php include 'partials/__footer.php';?>