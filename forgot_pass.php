<?php 
session_start();
$title = "Napsan Pharmacy || Forgot Password";
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
                <h1 class="font-semibold text-sm">Fill in the recovery code to reset password</h1>
                <p class="text-xs">NOTE: THIS IS FOR THE OWNER ONLY</p>
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
                <label for="username">Enter your username</label>
                <input type="text" name="username" id="username" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" autofocus>
            </div>
            <div class="">
                <label for="recov">Enter Recovery Code</label>
                <input type="text" name="recov" id="recov" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600">
            </div>

            <div class="">
                <button type="submit" name="fgot" class="w-full h-8 bg-green-600 text-white font-semibold hover:bg-green-700 active:opacity-80">Submit</button>
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

<?php include 'partials/__footer.php';?>