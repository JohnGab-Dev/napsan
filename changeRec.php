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

?>


<div class="w-full h-screen pt-10 flex px-4">
    <div class="w-[20%] h-full border-r py-10 flex flex-col gap-16">
        <h1 class="font-medium text-lg px-2">SETTINGS</h1>

        <div class="w-full h-5/5 flex flex-col font-medium">
            <a href="settings.php" class="w-full px-1 py-2 hover:bg-white">
                Change Password
            </a>
            <a href="changeRec.php" class="w-full px-1 py-2 bg-white hover:bg-white">
                Change Recovery Code
            </a>
            <a href="transacSettings.php" class="w-full px-1 py-2 hover:bg-white">
                Transactions
            </a>
            <a href="notifSettings.php" class="w-full px-1 py-2 hover:bg-white">
                Notifications
            </a>
        </div>
    </div>
    <div class="w-[80%] h-full p-4 ">
        <h1 class="font-medium">Change Recovery Code for Account Retrieval</h1>

        <form action="api/SettingsController.php" method="POST" class="w-full h-5/5 rounded-sm p-5 flex flex-col gap-4">
            <h1 class="text-xl font-bold text-red-600 px-2 py-1"><span class="text-green-700">N</span>APSAN Pharmacy</h1>
            <div class="">
                <h1 class="font-semibold text-sm">Change NAPSANs Account Recovery Code</h1>
                <p class="text-xs">Please fill all fields</p>
            </div>
            <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert flex w-full h-5/5 bg-red-200 border-l-4 border-red-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['error'];?></h1>
                    <button type="button" class="close p-1 hover:bg-slate-100 active:opacity-80"><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
            <?php unset($_SESSION['error']); }else if(isset($_SESSION['success'])){?>
                <div class="alertM flex w-full h-5/5 bg-green-200 border-l-4 border-green-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['success'];?></h1>
                    <button type="button" class="closeM p-1 hover:bg-slate-100 active:opacity-80" ><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
            <?php unset($_SESSION['success']); } ?>
            <div class="">
                <label for="oldRc">Enter Old Recovery Code</label>
                <input type="password" name="oldRc" id="oldRc" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" autofocus>
            </div>
            <div class="">
                <label for="nRc">Enter New Recovery Code</label>
                <input type="password" name="nRc" id="nRc" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600">
            </div>
            <div class="">
                <label for="cRc">Confirm New Recovery Code</label>
                <input type="password" name="cRc" id="cRc" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600">
            </div>

            <div class="">
                <button type="submit" name="changeRc" class="w-full h-8 bg-green-600 text-white font-semibold hover:bg-green-700 active:opacity-80">Save Changes</button>
            </div>

        </form>
    </div>


<script>
    document.querySelectorAll(".close, .closeM").forEach(button => {
        button.addEventListener("click", () => {
            button.closest(".alert, .alertM").classList.replace('flex','hidden');
        });
    });
</script>
</div>

<?php include 'partials/__footer.php';?>