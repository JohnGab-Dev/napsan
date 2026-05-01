<?php 
session_start();
$title = "Napsan Pharmacy || Settings";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/filter.php';
require 'popups/delNotif.php';
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
            <a href="transacSettings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Transactions
            </a>
            <a href="notifSettings.php" class="px-3 py-2 rounded-md bg-green-50 text-green-700 border-l-4 border-green-600">
                Notifications
            </a>
            <!-- <a href="repriceOH.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Replace Overhead
            </a>
            <a href="backup.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                Backup
            </a> -->
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-[78%] bg-white shadow-lg overflow-hidden rounded-lg p-6 flex flex-col gap-6">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold text-gray-700">Manage Notifications</h1>
                <p class="text-sm text-gray-500">View and manage all system notifications</p>
            </div>

            <?php if($_SESSION['user']['role'] == 'admin'){ ?>
                <button onclick="openDel()" class="delAll px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition shadow-sm">
                    Delete All
                </button>
            <?php } ?>
        </div>

        <!-- Search -->
        <div class="flex justify-between items-center">
            <h2 class="text-md font-medium text-gray-600">Notification List</h2>

            <div class="w-[40%] flex items-center gap-2 px-3 py-2 border rounded-lg bg-gray-50 focus-within:ring-2 focus-within:ring-green-500">
                <input 
                    type="text" 
                    id="myInput"
                    onkeyup="myFunction()" 
                    placeholder="Search notifications..." 
                    class="w-full bg-transparent outline-none text-sm"
                >
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>
        </div>

        <!-- Table -->
        <div class="w-full h-full border rounded-lg flex flex-col overflow-y-auto">

            <div class="">
                <table class="w-full text-sm" id="myTable">
                    <thead class="bg-green-600 text-white sticky top-0">
                        <tr>
                            <th class="p-3 text-left">Title</th>
                            <th class="p-3 text-left">Description</th>
                            <th class="p-3 text-left">Status</th>
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

                        $query = "SELECT * FROM notification ORDER BY created_at DESC LIMIT 20 OFFSET $offset";
                        $run_query = mysqli_query($con, $query);
                        $num_rows = mysqli_num_rows($run_query);

                        if($num_rows > 0){
                            while($row = mysqli_fetch_array($run_query)){
                                $trTime = date("m/d/Y", strtotime($row['created_at']));
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3"><?= $row['title']?></td>
                            <td class="p-3"><?= $row['description']?></td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs rounded-md font-medium 
                                    <?= $row['status'] == 'READ' 
                                        ? 'bg-green-100 text-green-700' 
                                        : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= $row['status']?>
                                </span>
                            </td>
                            <td class="p-3"><?= $trTime;?></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No notifications found!
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($num_rows != 0){ ?>
            <div class="flex justify-end gap-2 p-4">
                <a href="notifSettings.php?page=<?= $currPage - 1 ?>" class="<?= $currPage == 0 ? 'hidden' : '' ?>">
                    <button class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300 text-sm">
                        ← Previous
                    </button>
                </a>

                <a href="notifSettings.php?page=<?= $currPage + 1 ?>">
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
    function openDel(){
         document.querySelector(".delNotifui").classList.replace('hidden', 'flex')
    }

    function closeDel(){
        document.querySelector(".delNotifui").classList.replace('flex', 'hidden')
    }
</script>

<?php include 'partials/__footer.php';?>