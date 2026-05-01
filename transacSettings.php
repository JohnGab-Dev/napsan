<?php 
session_start();
$title = "Napsan Pharmacy || Transaction Settings";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/filter.php';
require 'popups/delSold.php';
require 'popups/alerts.php';

?>


<div class="w-full h-screen pt-20 px-4 pb-4 flex gap-4">

    <!-- Sidebar -->
    <div class="w-[22%] bg-white shadow-lg rounded-lg p-5 flex flex-col gap-6">
        <h1 class="font-semibold text-gray-700 text-lg">Settings</h1>

        <div class="flex flex-col gap-2 text-sm font-medium">
            <a href="settings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Change Password
            </a>
            <a href="changeRec.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Recovery Code
            </a>
            <a href="transacSettings.php" class="px-3 py-2 rounded-md bg-green-50 text-green-700 border-l-4 border-green-600">
                Transactions
            </a>
            <a href="notifSettings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Notifications
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-[78%] bg-white shadow-lg rounded-lg p-6 flex flex-col gap-6">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold text-gray-700">Manage Transactions</h1>
                <p class="text-sm text-gray-500">View and manage all sold products per transaction</p>
            </div>

            <?php if($_SESSION['user']['role'] == 'superadmin'){ ?>
                <button class="delAll px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition shadow-sm">
                    Delete All
                </button>
            <?php } ?>
        </div>

        <!-- Search -->
        <div class="flex justify-between items-center">
            <h2 class="text-md font-medium text-gray-600">Products Sold Per Transaction</h2>

            <div class="w-[40%] flex items-center gap-2 px-3 py-2 border rounded-lg bg-gray-50 focus-within:ring-2 focus-within:ring-green-500">
                <input 
                    type="text" 
                    id="myInput"
                    onkeyup="myFunction()" 
                    placeholder="Search transactions..." 
                    class="w-full bg-transparent outline-none text-sm"
                >
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>
        </div>

        <!-- Table -->
        <div class="w-full h-full overflow-hidden border rounded-lg overflow-y-auto">

            <div class="">
                <table class="w-full text-sm" id="myTable">
                    <thead class="bg-green-600 text-white sticky top-0">
                        <tr>
                            <th class="p-3 text-left">Tr No.</th>
                            <th class="p-3 text-left">Product</th>
                            <th class="p-3 text-left">Qty</th>
                            <th class="p-3 text-left">SRP</th>
                            <th class="p-3 text-left">Capital</th>
                            <th class="p-3 text-left">Total</th>
                            <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                                <th class="p-3 text-left">Profit</th>
                            <?php } ?>
                            <th class="p-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_GET['page'])){
                            $page = mysqli_real_escape_string($con, $_GET['page']);
                            $currPage = (int)$page;
                            $offset = $currPage * 20;
                        } else {
                            $currPage = 0;
                            $offset = 0;
                        }

                        $query = "SELECT products.name, productsold.transId, productsold.qty, productsold.srp, productsold.capital, productsold.total, productsold.profit, productsold.created_at 
                                  FROM productsold 
                                  JOIN products ON productsold.productId = products.productId 
                                  ORDER BY productsold.transId DESC 
                                  LIMIT 20 OFFSET $offset";

                        $run_query = mysqli_query($con, $query);

                        if(mysqli_num_rows($run_query) > 0){
                            while($row = mysqli_fetch_array($run_query)){
                                $trTime = date("m/d/Y", strtotime($row['created_at']));
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3"><?= $row['transId']?></td>
                            <td class="p-3"><?= $row['name']?></td>
                            <td class="p-3"><?= $row['qty']?></td>
                            <td class="p-3">₱<?= $row['srp']?></td>
                            <td class="p-3">₱<?= $row['capital']?></td>
                            <td class="p-3">₱<?= $row['total']?></td>
                            <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                                <td class="p-3">₱<?= $row['profit']?></td>
                            <?php } ?>
                            <td class="p-3"><?= $trTime;?></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No Sold Items Found!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if(mysqli_num_rows($run_query) != 0){ ?>
            <div class="flex justify-end gap-2 p-4 border-t">
                <a href="transacSettings.php?page=<?= $currPage - 1 ?>" class="<?= $currPage == 0 ? 'hidden' : '' ?>">
                    <button class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 text-sm">
                        ← Previous
                    </button>
                </a>

                <a href="transacSettings.php?page=<?= $currPage + 1 ?>">
                    <button class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 text-sm">
                        Next →
                    </button>
                </a>
            </div>
            <?php } ?>

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