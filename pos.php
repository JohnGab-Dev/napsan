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
    <div class="w-full min-h-screen pt-20 px-4 flex gap-4">
        <div class="w-1/2 h-[40rem] bg-white p-6 shadow-lg rounded-lg">
            <h1 class="font-semibold text-lg text-gray-700">Search items here</h1>
            <div class="w-full flex justify-center mt-4">
                <form action="api/searchController.php" method="post" class="w-full relative">
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
                        <button type="submit" name="find" class="absolute right-0 top-0 h-full px-6 bg-green-600 rounded-r-xl text-white font-semibold hover:bg-green-700 transition">
                            Search
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-full px-2 py-2"></div>

            <div class="w-full h-[83%] overflow-y-auto">
                <table class="w-full font-medium text-sm border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-green-600 text-white uppercase tracking-wide text-left">
                            <th class="p-3">Product Name</th>
                            <th class="p-3">Stock</th>
                            <th class="p-3">SRP</th>
                            <th class="p-3">QTY</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['search'])){
                            $search = mysqli_real_escape_string($con, $_GET['search']);
                            $query = "SELECT * FROM products WHERE name LIKE '%$search%'";
                            $run_query = mysqli_query($con, $query);

                            if(mysqli_num_rows($run_query) > 0){
                                while($row = mysqli_fetch_array($run_query)){
                                    $lowStock = $row['qty'] <= 5; // Highlight low stock
                        ?>
                        <tr class="transition hover:shadow-md hover:bg-gray-50 rounded-lg <?= $lowStock ? 'bg-red-50' : '' ?>">
                            <td class="p-3"><?= $row['name']?></td>
                            <td class="p-3 <?= $lowStock ? 'text-red-600 font-semibold' : '' ?>"><?= $row['qty']?></td>
                            <td class="p-3">P<?= number_format($row['srp'], 2)?></td>
                            <td class="p-3">
                                <form action="api/POSController.php?id=<?= $row['productId']?>" method="post">
                                    <input type="number" name="qty" min="1" class="w-20 h-8 px-2 border border-gray-300 rounded-md outline-none focus:ring-2 focus:ring-green-500" placeholder="QTY" required>
                            </td>
                            <td class="p-3">
                                <button type="submit" name="addtocart" class="px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium transition">Add to Cart</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr class="text-center">
                            <td colspan="5" class="p-3 font-medium text-gray-500">No Products Found!</td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr class="text-center">
                            <td colspan="5" class="p-3 font-medium text-gray-500">Search For Products First</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="scr w-1/2 h-[40rem] bg-white rounded-lg shadow-lg flex flex-col gap-4 overflow-y-auto pb-4">
            <div class="w-full h-1/2 border-b p-6">
                <div class="w-full mb-2">
                    <h1 class="font-semibold text-lg text-gray-700">Products added to cart</h1>
                </div>

                <div class="w-full h-[90%] overflow-y-auto">
                    <table class="w-full font-medium text-sm border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-green-600 text-white uppercase tracking-wide text-left">
                                <th class="p-3">Product Name</th>
                                <th class="p-3">QTY</th>
                                <th class="p-3">SRP</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query1 = "SELECT cart.cartId, cart.productId, cart.qty as Cqty, cart.srp, cart.capital, cart.total, products.name 
                                    FROM cart 
                                    JOIN products ON cart.productId = products.productId 
                                    ORDER BY cart.created_at DESC";
                            $run_query1 = mysqli_query($con, $query1);
                            $sub_total = 0;

                            if(mysqli_num_rows($run_query1) > 0){
                                while($row1 = mysqli_fetch_array($run_query1)){
                                    $sub_total += $row1['total'];
                            ?>
                            <tr class="transition hover:shadow-md hover:bg-gray-50 rounded-lg">
                                <td class="p-3"><?= $row1['name']?></td>
                                <td class="p-3"><?= $row1['Cqty']?></td>
                                <td class="p-3">P<?= number_format($row1['srp'], 2)?></td>
                                <td class="p-3">P<?= number_format($row1['total'], 2)?></td>
                                <td class="p-3 flex items-center gap-2">
                                    <button type="button" onclick="editCart(<?= $row1['cartId']?>)" class="px-2 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium transition">Edit</button>
                                    <?php require 'popups/editCart.php';?>
                                    <form action="api/POSController.php?id=<?= $row1['cartId'];?>" method="post">
                                        <button type="submit" name="delCart" class="px-2 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white font-medium transition">Del</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="5" class="p-3 font-medium text-gray-500">No Products Added</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                                
                
            </div>
            <form action="api/POSController.php" method="post" class="w-full h-1/2 flex flex-col px-4 gap-4 p-4 overflow-y-auto scr">
                
                <!-- SUB-TOTAL -->
                <div class="flex justify-between items-center">
                    <label class="font-semibold text-gray-700">SUB-TOTAL (PHP):</label>
                    <input type="text" name="subtotal" class="sub w-2/3 text-right px-3 py-2 bg-gray-100 border rounded-md font-medium outline-none" readonly value="<?= number_format($sub_total, 2);?>" required>
                </div>

                <!-- DISCOUNT -->
                <div class="flex justify-between items-center">
                    <label class="font-semibold text-gray-700">DISCOUNT (PHP):</label>
                    <input type="number" name="discount" step="any" class="dis w-2/3 px-3 py-2 border rounded-md outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 font-medium" value="0">
                </div>

                <!-- TOTAL -->
                <div class="flex justify-between items-center">
                    <label class="font-semibold text-gray-700">TOTAL (PHP):</label>
                    <input type="text" name="total" class="total w-2/3 text-right px-3 py-2 bg-gray-100 border rounded-md font-medium outline-none" readonly value="<?= number_format($sub_total, 2);?>" required>
                </div>

                <!-- PAYMENT METHODS -->
                <div class="flex items-center gap-4">
                    <span class="font-semibold text-gray-700">Payment Methods:</span>

                    <input type="radio" name="methods" id="method1" class="hidden" required value="Cash">
                    <label for="method1" class="method px-4 py-2 border rounded-md cursor-pointer hover:bg-green-100 text-gray-700 font-medium">CASH</label>

                    <input type="radio" name="methods" id="method2" class="hidden" required value="Gcash">
                    <label for="method2" class="method px-4 py-2 border rounded-md cursor-pointer hover:bg-green-100 text-gray-700 font-medium">G-CASH</label>

                    <input type="number" name="refnum" placeholder="Ref. num (if GCASH)" class="ml-auto min-w-lg px-3 py-2 border rounded-md outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 font-medium">
                </div>

                <!-- AMOUNT TENDERED -->
                <div class="flex justify-between items-center">
                    <label class="font-semibold text-gray-700">AMOUNT TENDERED (PHP):</label>
                    <input type="number" step="any" name="amount" placeholder="0.00" class="w-2/3 px-3 py-2 border rounded-md outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 font-medium" required>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex justify-end items-center gap-4">
                    <button type="submit" name="checkout" class="px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white font-semibold transition">Checkout</button>
                    <button type="submit" name="abort" class="px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white font-semibold transition">Cancel</button>
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