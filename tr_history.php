<?php 
session_start();
$title = "Napsan Pharmacy || Transaction History";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/filter.php';
require 'popups/delTr.php'

?>
    <div class="w-full h-screen pt-20 px-4 pb-4">
        <div class="w-full h-full bg-white shadow-lg rounded-lg p-6 flex flex-col gap-4">

            <!-- HEADER -->
            <div class="w-full flex justify-between flex-wrap gap-3">

                <!-- Tabs + Actions -->
                <div class="flex flex-wrap items-center gap-2 font-medium">
                    <a href="transactions.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                        Transactions Today
                    </a>
                    <a href="tr_history.php" class="px-4 py-2 rounded-t-md border-b-2 border-green-600 bg-green-50 text-green-800">
                        Transaction History
                    </a>

                    <!-- Filter -->
                    <button class="trig ml-3 px-3 py-2 bg-gray-100 border rounded-md hover:bg-gray-200 transition flex items-center gap-2">
                        Filter Date
                        <img src="imgs/chev.png" class="w-3 h-3">
                    </button>

                    <?php if($_SESSION['user']['role'] == 'superadmin'){ ?>
                    <button class="delAll px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Delete All
                    </button>
                    <?php } ?>
                </div>

                <!-- Search -->
                <div class="w-full md:w-2/5">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                            </svg>
                        </div>

                        <input 
                            type="text" 
                            id="myInput"
                            onkeyup="myFunction()"
                            placeholder="Search transactions..."
                            class="w-full rounded-xl bg-gray-100 pl-10 pr-4 py-3 text-gray-700 shadow-sm focus:bg-white focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                        >
                    </div>
                </div>

            </div>

            <!-- TABLE -->
            <div class="w-full h-[65%] overflow-y-auto">
                <table id="myTable" class="w-full text-left border-collapse">

                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="p-3 rounded-tl-lg">Transaction No.</th>
                            <th class="p-3">Sub-Total</th>
                            <th class="p-3">Discount</th>
                            <th class="p-3">Total</th>
                            <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                            <th class="p-3">Profit</th>
                            <?php } ?>
                            <th class="p-3">Mode</th>
                            <th class="p-3">Reference</th>
                            <th class="p-3">Date & Time</th>
                            <th class="p-3 rounded-tr-lg">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <?php
                            $date = date('Y-m-d');

                            if(!isset($_GET['date'])){
                                if(isset($_GET['page'])){
                                    $page = mysqli_real_escape_string($con, $_GET['page']);
                                    $currPage = -1 + $page;
                                    $date = date('Y-m-d', strtotime($currPage.' days'));
                                }else{
                                    $currPage = 0;
                                    $date = date('Y-m-d', strtotime('-1 days'));
                                }
                            } else {
                                $date = date("Y-m-d", strtotime($_GET['date']));
                                $currPage = 0;
                            }

                            $query = "SELECT * FROM transactions WHERE date_created = '$date' ORDER BY created_at DESC";
                            $run_query = mysqli_query($con, $query);

                            $total = 0;
                            $gcash = 0;
                            $cash = 0;
                            $profit = 0;

                            if(mysqli_num_rows($run_query)>0){
                                while($row = mysqli_fetch_array($run_query)){

                                    $trTime = date("M d, Y h:i A", strtotime($row['created_at']));

                                    $total += $row['total'];
                                    $profit += $row['profit'];

                                    if($row['mode_of_payment'] == 'Cash'){
                                        $cash += $row['total'];
                                    } else {
                                        $gcash += $row['total'];
                                    }
                        ?>

                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-2 font-medium"><?= $row['transId']?></td>
                            <td class="p-2">₱<?= number_format($row['subtotal'],2)?></td>
                            <td class="p-2">₱<?= number_format($row['discount'],2)?></td>
                            <td class="p-2 font-semibold">₱<?= number_format($row['total'],2)?></td>

                            <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                            <td class="p-2 text-green-700 font-medium">₱<?= number_format($row['profit'],2)?></td>
                            <?php } ?>

                            <td class="p-2">
                                <span class="px-2 py-1 text-xs rounded-full <?= $row['mode_of_payment'] == 'Cash' ? 'bg-yellow-200 text-yellow-800' : 'bg-blue-200 text-blue-800' ?>">
                                    <?= $row['mode_of_payment'] ?>
                                </span>
                            </td>

                            <td class="p-2"><?= $row['ref_num']?></td>
                            <td class="p-2"><?= $trTime ?></td>

                            <td class="p-2 flex flex-wrap gap-2">
                                <a href="receipt.php?id=<?= $row['transId']?>">
                                    <button class="text-xs px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md">View</button>
                                </a>
                                <a href="editTr.php?id=<?= $row['transId']?>">
                                    <button class="text-xs px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Edit</button>
                                </a>

                                <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                                <form action="api/TransactionController.php?id=<?= $row['transId']?>" method="post">
                                    <button type="submit" name="delTr" 
                                        class="text-xs px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md">
                                        Delete
                                    </button>
                                </form>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php }} else { ?>
                            <tr>
                                <td colspan="9" class="p-4 text-center text-gray-500 font-medium">
                                    No Transactions Found!
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <?php if(!isset($_GET['date']) && mysqli_num_rows($run_query) > 0){ ?>
                <div class="w-full flex justify-end py-4 gap-2">
                    <a href="tr_history.php?page=<?= $currPage - 1 ?>">
                        <button class="px-3 py-1 bg-white border rounded-md hover:bg-gray-100">&lt; Previous</button>
                    </a>
                    <a href="tr_history.php?page=<?= $currPage + 1 ?>">
                        <button class="px-3 py-1 bg-white border rounded-md hover:bg-gray-100">Next &gt;</button>
                    </a>
                </div>
                <?php } ?>

            </div>

            <!-- SUMMARY -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                <div class="col-span-2 md:col-span-1">
                    <p class="text-sm text-gray-500">Selected Date</p>
                    <h2 class="text-lg font-semibold"><?= date("F j, Y", strtotime($date)); ?></h2>
                </div>

                <div class="bg-white border-l-4 border-blue-600 shadow-md rounded-lg p-4">
                    <p class="text-sm text-gray-500">Gcash</p>
                    <h2 class="text-xl font-semibold">₱<?= number_format($gcash,2)?></h2>
                </div>

                <div class="bg-white border-l-4 border-yellow-600 shadow-md rounded-lg p-4">
                    <p class="text-sm text-gray-500">Cash</p>
                    <h2 class="text-xl font-semibold">₱<?= number_format($cash,2)?></h2>
                </div>

                <div class="bg-white border-l-4 border-green-600 shadow-md rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total</p>
                    <h2 class="text-xl font-semibold">₱<?= number_format($total,2)?></h2>
                </div>

                <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                <div class="bg-white border-l-4 border-red-600 shadow-md rounded-lg p-4">
                    <p class="text-sm text-gray-500">Profit</p>
                    <h2 class="text-xl font-semibold">₱<?= number_format($profit,2)?></h2>
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