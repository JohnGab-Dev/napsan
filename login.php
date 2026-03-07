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
    }
?>

<div class="min-h-screen flex">

    <!-- LEFT SIDE (Image / Branding) -->
    <div class="hidden lg:flex w-1/2 bg bg-cover bg-center items-center justify-center relative">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative text-white text-center px-10">
            <h1 class="text-5xl font-bold mb-4">
                <span class="text-green-400">N</span>
                <span class="text-red-500">APSAN</span>
                Pharmacy
            </h1>

            <p class="text-lg">
                Providing trusted medicines and healthcare products
                for the community of San Ildefonso, Bulacan.
            </p>

            <div class="mt-6 text-sm space-y-2">
                <p>✔ Quality Medicines</p>
                <p>✔ Affordable Prices</p>
                <p>✔ Trusted Pharmacy</p>
            </div>
        </div>

    </div>


    <!-- RIGHT SIDE (Login Form) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-100 px-6">

        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-xl flex flex-col gap-6">

            <!-- Logo -->
            <h2 class="text-2xl font-bold text-center border-b pb-3">
                <span class="text-green-700">N<span class="text-red-600">APSAN</span></span>
                Pharmacy
            </h2>

            <!-- Text -->
            <div class="text-center">
                <h3 class="font-semibold text-lg">Welcome Back</h3>
                <p class="text-sm text-gray-500">Login to your account</p>
            </div>


            <!-- ALERT -->
            <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert flex justify-between items-center bg-red-100 border-l-4 border-red-500 text-red-700 px-3 py-2 rounded text-sm">
                    <span><?= $_SESSION['error']; ?></span>
                    <button class="close font-bold text-lg">&times;</button>
                </div>
            <?php unset($_SESSION['error']); } ?>

            <?php if(isset($_SESSION['success'])){ ?>
                <div class="alert flex justify-between items-center bg-green-100 border-l-4 border-green-500 text-green-700 px-3 py-2 rounded text-sm">
                    <span><?= $_SESSION['success']; ?></span>
                    <button class="close font-bold text-lg">&times;</button>
                </div>
            <?php unset($_SESSION['success']); } ?>


            <!-- FORM -->
            <form action="api/LoginController.php" method="POST" class="flex flex-col gap-5">

                <!-- USERNAME -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Username</label>
                    <input
                        type="text"
                        name="username"
                        autofocus
                        class="border rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none"
                    >
                </div>

                <!-- PASSWORD -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium">Password</label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="border rounded-md px-3 py-2 w-full focus:ring-2 focus:ring-green-500 outline-none"
                        >

                        <button
                            type="button"
                            id="toggleBtn"
                            onclick="togglePassword()"
                            class="absolute right-3 top-2 text-sm text-gray-500"
                        >
                            Show
                        </button>
                    </div>

                    <div class="flex justify-between items-center text-sm mt-1">
                        <a href="forgot_pass.php" class="text-blue-600 hover:underline">
                            Forgot Password?
                        </a>
                    </div>
                </div>


                <!-- BUTTON -->
                <button
                    type="submit"
                    name="login"
                    class="bg-green-600 text-white py-2.5 rounded-md font-semibold hover:bg-green-700 transition"
                >
                    Login
                </button>

            </form>

        </div>

    </div>

</div>
<script>
    const alert = document.querySelector(".alert");
    const close = document.querySelector(".close");

    close.addEventListener("click", ()=> {
        alert.classList.replace('flex','hidden');
    })

    function togglePassword(){
        const input = document.getElementById("password");
        const btn = document.getElementById("toggleBtn");

        if(input.type === "password"){
            input.type = "text";
            btn.innerText = "Hide";
        }else{
            input.type = "password";
            btn.innerText = "Show";
        }
    }
   
</script>

<?php
    include 'partials/__footer.php';
?>