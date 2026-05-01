<?php 
session_start();
$title = "Napsan Pharmacy || Login";
include 'partials/__header.php';

if(isset($_SESSION['user'])){
    if($_SESSION['user']['role'] == 'admin'){
        header("Location: dashboard.php");
        exit();
    }else if($_SESSION['user']['role'] == 'cashier'){
        header("Location: pos.php");
        exit();
    }
}else{
    if(!isset($_SESSION['fgot'])){
        header("Location: forgot_pass.php");
        exit();
    }
}
?>

<div class="bg-[url(./imgs/bg.jpg)] bg-cover w-full min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 flex flex-col gap-6">

        <!-- Header -->
        <h1 class="text-2xl font-bold text-center border-b pb-3">
            <span class="text-red-600"><span class="text-green-700">N</span>APSAN</span> Pharmacy
        </h1>

        <!-- Instructions -->
        <div class="text-center">
            <h2 class="font-semibold text-lg">Reset your password</h2>
            <p class="text-sm text-gray-500">
                Please enter your new password
            </p>
        </div>

        <!-- Alerts -->
        <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert flex items-center justify-between bg-red-100 border-l-4 border-red-500 text-red-700 px-3 py-2 rounded text-sm">
                <span><?= $_SESSION['error']; ?></span>
                <button type="button" class="close font-bold text-lg">&times;</button>
            </div>
        <?php unset($_SESSION['error']); } ?>

        <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert flex items-center justify-between bg-green-100 border-l-4 border-green-500 text-green-700 px-3 py-2 rounded text-sm">
                <span><?= $_SESSION['success']; ?></span>
                <button type="button" class="close font-bold text-lg">&times;</button>
            </div>
        <?php unset($_SESSION['success']); } ?>

        <!-- Form -->
        <form action="api/LoginController.php" method="POST" class="flex flex-col gap-5">

            <!-- New Password -->
            <div class="flex flex-col gap-1">
                <label for="npass" class="text-sm font-medium text-gray-700">
                    New Password
                </label>

                <input
                    type="password"
                    name="npass"
                    id="npass"
                    required
                    autofocus
                    class="border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none"
                >
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-1">
                <label for="cpass" class="text-sm font-medium text-gray-700">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="cpass"
                    id="cpass"
                    required
                    class="border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none"
                >
            </div>

            <!-- Submit -->
            <button
                type="submit"
                name="save"
                class="bg-green-600 text-white py-2.5 rounded-md font-semibold hover:bg-green-700 transition"
            >
                Save Changes
            </button>

        </form>

    </div>

</div>

<script>
    const alert = document.querySelector(".alert");
    const close = document.querySelector(".close");

    if(close){
        close.addEventListener("click", ()=> {
            alert.classList.replace('flex','hidden');
        });
    }
</script>

<?php include 'partials/__footer.php';?>