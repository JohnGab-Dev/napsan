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

<div class="bg w-full h-screen ">
    <div class="bg1 w-full h-full flex items-center justify-center">
        <form action="api/LoginController.php" method="POST" class="w-2/6 h-5/5 bg-white rounded-sm p-5 flex flex-col gap-4 shadow-lg">
            <h1 class="text-xl font-bold text-red-600 px-2 py-1 border bg-slate-100"><span class="text-green-700">N</span>APSAN Pharmacy</h1>
            <div class="">
                <h1 class="font-semibold text-sm">Log in to your account</h1>
                <p class="text-xs">Please fill all fields</p>
            </div>
            <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert flex w-full h-5/5 bg-red-200 border-l-4 border-red-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['error'];?></h1>
                    <button type="button" class="close p-1 hover:bg-slate-100 active:opacity-80"><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
            <?php unset($_SESSION['error']); }else if(isset($_SESSION['success'])){?>
                <div class="alert flex w-full h-5/5 bg-green-200 border-l-4 border-green-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['success'];?></h1>
                    <button type="button" class="close p-1 hover:bg-slate-100 active:opacity-80" ><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
            <?php unset($_SESSION['success']); } ?>
            <div class="">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" autofocus>
            </div>
            <div class="">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600">
                <p class="mt-1 text-sm text-blue-600 hover:underline text-right"><a href="forgot_pass.php" >Forgot Password?</a></p>
            </div>

            <div class="">
                <button type="submit" name="login" class="w-full h-8 bg-green-600 text-white font-semibold hover:bg-green-700 active:opacity-80">Login</button>
            </div>

        </form>
    </div>
    
</div>
<script>
    const alert = document.querySelector(".alert");
    const close = document.querySelector(".close");

    close.addEventListener("click", ()=> {
        alert.classList.replace('flex','hidden');
    })
   
</script>

<?php
    include 'partials/__footer.php';
?>