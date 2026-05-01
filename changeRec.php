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


    <div class="w-full h-screen pt-20 px-4 pb-4 flex gap-4">

        <!-- Sidebar -->
        <div class="w-[22%] bg-white shadow-lg rounded-lg p-5 flex flex-col gap-6">
            <h1 class="font-semibold text-gray-700 text-lg">Settings</h1>

            <div class="flex flex-col gap-2 text-sm font-medium">
                <a href="settings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                    Change Password
                </a>
                <a href="changeRec.php" class="px-3 py-2 rounded-md bg-green-50 text-green-700 border-l-4 border-green-600">
                    Recovery Code
                </a>
                <a href="transacSettings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
                    Transactions
                </a>
                <a href="notifSettings.php" class="px-3 py-2 rounded-md hover:bg-gray-100 transition">
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
        <div class="w-[78%] bg-white shadow-lg rounded-lg p-6 flex flex-col gap-6">

            <!-- Header -->
            <div>
                <h1 class="text-xl font-semibold text-gray-700">Change Recovery Code</h1>
                <p class="text-sm text-gray-500">Update your account recovery code for security</p>
            </div>

            <!-- Form -->
            <form action="api/SettingsController.php" method="POST" class="flex flex-col gap-5 max-w-xl">

                <!-- Alerts -->
                <?php if(isset($_SESSION['error'])){ ?>
                    <div class="alert flex items-center justify-between bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-2 rounded-md text-sm shadow-sm">
                        <span><?= $_SESSION['error'];?></span>
                        <button type="button" class="close text-lg">&times;</button>
                    </div>
                <?php unset($_SESSION['error']); } ?>

                <?php if(isset($_SESSION['success'])){ ?>
                    <div class="alertM flex items-center justify-between bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-2 rounded-md text-sm shadow-sm">
                        <span><?= $_SESSION['success'];?></span>
                        <button type="button" class="closeM text-lg">&times;</button>
                    </div>
                <?php unset($_SESSION['success']); } ?>

                <!-- Old Code -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-600">Old Recovery Code</label>
                    <input 
                        type="password" 
                        name="oldRc" 
                        required
                        class="rounded-lg border border-gray-300 px-4 py-2 
                            focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                    >
                </div>

                <!-- New Code -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-600">New Recovery Code</label>
                    <input 
                        type="password" 
                        name="nRc" 
                        required
                        class="rounded-lg border border-gray-300 px-4 py-2 
                            focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                    >
                </div>

                <!-- Confirm Code -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm text-gray-600">Confirm Recovery Code</label>
                    <input 
                        type="password" 
                        name="cRc" 
                        required
                        class="rounded-lg border border-gray-300 px-4 py-2 
                            focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                    >
                </div>

                <!-- Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        name="changeRc" 
                        class="w-full py-2 bg-green-600 text-white font-semibold rounded-md 
                            hover:bg-green-700 transition shadow-sm">
                        Save Changes
                    </button>
                </div>

            </form>
        </div>

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