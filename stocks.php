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
    <div class="w-full h-screen pt-20 px-4 pb-4">
        <div class="w-full h-full bg-white shadow-lg rounded-lg p-6 flex flex-col gap-4">

            <!-- HEADER -->
            <div class="w-full flex justify-between flex-wrap gap-3">

                <!-- Tabs -->
                <div class="flex flex-wrap items-center gap-2 font-medium">
                    <a href="inventory.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                        Products Inventory
                    </a>
                    <a href="stocks.php" class="px-4 py-2 rounded-t-md border-b-2 border-green-600 bg-green-50 text-green-800">
                        Stocks Deliveries
                    </a>
                    <a href="low_stock.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                        Low Stocks
                    </a>
                    <a href="expiring.php" class="px-4 py-2 rounded-t-md border-b-2 border-transparent hover:border-green-600 hover:bg-green-50 transition">
                        Expiring Products
                    </a>

                    <?php if($_SESSION['user']['role'] == 'superadmin'){ ?>
                        <button class="delAll ml-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
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
                            placeholder="Search stock deliveries..."
                            class="w-full rounded-xl bg-gray-100 pl-10 pr-4 py-3 text-gray-700 shadow-sm focus:bg-white focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                        >
                    </div>
                </div>

            </div>

            <!-- TABLE -->
            <div class="w-full h-[90%] overflow-y-auto">
                <table id="myTable" class="w-full text-left border-collapse">
                    
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="p-3 rounded-tl-lg">Date Inputted</th>
                            <th class="p-3">Product Name</th>
                            <th class="p-3">Stocks In</th>
                            <th class="p-3">Expiry</th>
                            <th class="p-3">Distributor</th>
                            <th class="p-3 rounded-tr-lg">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <?php 
                            if(isset($_GET['page'])){
                                $page = mysqli_real_escape_string($con, $_GET['page']);
                                $currPage = $page;
                                $offset = $currPage * 20;
                                $query = "SELECT stock_expiry.*, products.*, stock_expiry.created_at as del_date 
                                        FROM stock_expiry 
                                        JOIN products ON stock_expiry.productId = products.productId 
                                        ORDER BY stock_expiry.created_at DESC 
                                        LIMIT 20 OFFSET $offset";
                            }else{
                                $currPage = 0;
                                $query = "SELECT stock_expiry.*, products.*, stock_expiry.created_at as del_date 
                                        FROM stock_expiry 
                                        JOIN products ON stock_expiry.productId = products.productId 
                                        ORDER BY stock_expiry.created_at DESC 
                                        LIMIT 20";
                            }

                            $run_query = mysqli_query($con, $query);

                            if(mysqli_num_rows($run_query) > 0){
                                while($row = mysqli_fetch_array($run_query)){

                                    $date1 = date("F j, Y", strtotime($row['del_date']));
                                    $expiry = date("F j, Y", strtotime($row['expiry']));
                        ?>
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-2"><?= $date1 ?></td>
                            <td class="p-2 font-medium"><?= $row['name'] ?></td>
                            <td class="p-2"><?= $row['stocks_in'] ?></td>
                            <td class="p-2"><?= $expiry ?></td>
                            <td class="p-2"><?= $row['distributor'] ?></td>
                            <td class="p-2">
                                <button onclick="openEdit(<?= $row['stId']?>)" 
                                    class="text-xs px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                    Edit
                                </button>
                                <?php require 'popups/editStock.php'; ?>
                            </td>
                        </tr>

                        <?php }} else { ?>
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500 font-medium">
                                    No Stock Deliveries Conducted!
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <div class="w-full flex justify-end py-4 gap-2">
                    <a href="stocks.php?page=<?= $currPage - 1 ?>" class="<?= $currPage == 0 ? 'hidden' : '' ?>">
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 transition">
                            &lt; Previous
                        </button>
                    </a>

                    <a href="stocks.php?page=<?= $currPage + 1 ?>">
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 transition">
                            Next &gt;
                        </button>
                    </a>
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