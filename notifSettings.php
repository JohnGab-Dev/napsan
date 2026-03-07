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


<div class="w-full h-screen pt-10 flex px-4">
    <div class="w-[20%] h-full border-r py-10 flex flex-col gap-16">
        <h1 class="font-medium text-lg px-2">SETTINGS</h1>

        <div class="w-full h-5/5 flex flex-col font-medium">
            <a href="settings.php" class="w-full px-1 py-2 hover:bg-white">
                Change Password
            </a>
            <a href="changeRec.php" class="w-full px-1 py-2 hover:bg-white">
                Change Recovery Code
            </a>
            <a href="transacSettings.php" class="w-full px-1 py-2 hover:bg-white">
                Transactions
            </a>
            <a href="notifSettings.php" class="w-full px-1 py-2 bg-white hover:bg-white">
                Notifications
            </a>
        </div>
    </div>
    <div class="w-[80%] h-full p-4 flex flex-col gap-2">
        <div class="w-auto h-auto flex items-center justify-between font-medium">
                <h1 class="font-medium">Manage Notifications</h1>
                <?php if($_SESSION['user']['role'] == 'admin'){?>
                <button class="delAll ml-2 px-2 py-1 rounded-sm bg-red-600 font-medium text-white hover:bg-red-700 active:opacity-80">Delete All</button>
                <?php }?>
        </div>
        <div class="w-full h-[95%] bg-white shadow-md rounded-sm p-4 flex flex-col gap-4">
            <div class="w-full h-10rem flex justify-between">
                <h1 class="font-medium">Products Sold Per Transaction</h1>
                <div class="w-2/5 h-10 bg-slate-100 flex items-center gap-2 px-2 rounded-sm hover:bg-slate-200">
                    <input type="text" class="w-11/12 outline-none py-1 bg-slate-100 focus:border-b-2 focus:border-green-600 px-2" placeholder="search here..." autofocus id="myInput" onkeyup="myFunction()">
                    <img src="imgs/search.png" alt="" class="w-7">
                </div>
            </div>  

            <div class="w-full h-full overflow-y-auto">
                <table class="w-full font-medium" id="myTable">
                    <thead>
                        <tr class="border-y bg-green-600 text-white">
                            <th class="p-1 text-left">Title</th>
                            <th class="p-1 text-left">Description</th>
                            <th class="p-1 text-left">Status</th>
                            <th class="p-1 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_GET['page'])){
                                    $page = mysqli_real_escape_string($con, $_GET['page']);
                                    $currPage = 0;
                                    $currPage = $currPage + $page;
                                    $offset = $currPage * 20;
                                    $query = "SELECT * FROM notification ORDER BY created_at DESC LIMIT 20 OFFSET $offset";
                            }else{
                                    $query = "SELECT * FROM notification ORDER BY created_at DESC LIMIT 20";
                            }
                            $run_query = mysqli_query($con, $query);
                            $num_rows = mysqli_num_rows($run_query);

                            if($num_rows>0){
                                while($row = mysqli_fetch_array($run_query)){
                                    $trTime = $row['created_at'];
                                    $trTime = date("m/d/Y", strtotime($trTime));

                        ?>
                        <tr class="border-b border-slate-400 hover:bg-slate-100">
                            <td class="p-1 text-sm"><?= $row['title']?></td>
                            <td class="p-1"><?= $row['description']?></td>
                            <td class="p-1 text-xs"><span class="p-1 <?= $row['status'] == 'READ' ? 'bg-green-100' : 'bg-yellow-100'?>"><?= $row['status']?></span></td>
                            <td class="p-1 text-left"><?= $trTime;?> </td>
                        </tr> 
                        <?php
                                }
                            }else{
                            ?>
                            <tr class="text-center">
                                <td colspan="9" class="p-1 font-medium">No notifications found!</td>
                            </tr>
                        <?php } ?> 
                        
                    </tbody>
                </table>
                <?php if($num_rows != 0){?>
                <div class="w-full h-auto flex items-center justify-end py-4 px-2 gap-2">
                    <a href="notifSettings.php?page=<?= isset($_GET['page']) ? $_GET['page'] - 1 : -1;?>" class="<?= $currPage == 0 ? 'hidden' : ''?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">< Previous</button></a>
                    <a href="notifSettings.php?page=<?= isset($_GET['page']) ? $_GET['page'] + 1 : 1;?>"><button class="bg-slate-200 p-1 rounded-sm hover:bg-slate-300 font-medium active:opacity-80">Next ></button></a>
                </div>
                <?php }?>
            </div>
            
        </div>


    </div>
</div>

<?php include 'partials/__footer.php';?>