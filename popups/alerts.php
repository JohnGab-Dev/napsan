<?php if(isset($_SESSION['error'])){ ?>
    <div class="alertE flex fixed bottom-10 right-10 w-auto h-5/5 bg-red-600 text-white items-center justify-between px-2 text-sm py-1 rounded-sm z-20 gap-2">
        <h1><?= $_SESSION['error'];?></h1>
        <button type="button" class="closeE p-1 hover:bg-slate-100 active:opacity-80"><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
    </div>
    <script>
        const alertE = document.querySelector(".alertE");
        const closeE = document.querySelector(".closeE");

        closeE.addEventListener("click", ()=> {
            alertE.classList.replace('flex','hidden');
        })
    </script>
<?php unset($_SESSION['error']); 
}else if(isset($_SESSION['success'])){?>
    <div class="alertM flex fixed bottom-10 right-10 w-auto h-5/5 bg-green-500 text-white items-center justify-between px-2 text-sm py-2 rounded-sm z-20 gap-2">
            <h1><?= $_SESSION['success'];?></h1>
            <button type="button" class="closeM p-1 hover:bg-slate-100 active:opacity-80" ><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
    </div>
    <script>
        const alertS = document.querySelector(".alertM");
        const closeS = document.querySelector(".closeM");
        closeS.addEventListener("click", ()=> {
            alertS.classList.replace('flex','hidden');  
        })
    </script>
<?php unset($_SESSION['success']); } ?>


<?php if(isset($_SESSION['errorCart'])){ ?>
    <div class="alertEC flex fixed top-[3rem] right-10 w-auto h-5/5 bg-red-600 text-white items-center justify-between px-2 text-sm py-1 rounded-sm z-20 gap-2">
        <h1><?= $_SESSION['errorCart'];?></h1>
        <button type="button" class="closeEC p-1 hover:bg-slate-100 active:opacity-80"><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
    </div>
    <script>
        const alertEC = document.querySelector(".alertEC");
        const closeEC = document.querySelector(".closeEC");

        closeEC.addEventListener("click", ()=> {
            alertEC.classList.replace('flex','hidden');
        })
    </script>
<?php unset($_SESSION['errorCart']); 
}else if(isset($_SESSION['successCart'])){?>
    <div class="alertMC flex fixed top-[3rem] right-10 w-auto h-5/5 bg-green-500 text-white items-center justify-between px-2 text-sm py-2 rounded-sm z-20 gap-2">
            <h1><?= $_SESSION['successCart'];?></h1>
            <button type="button" class="closeMC p-1 hover:bg-slate-100 active:opacity-80" ><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
    </div>
    <script>
        const alertSC = document.querySelector(".alertMC");
        const closeSC = document.querySelector(".closeMC");
        closeSC.addEventListener("click", ()=> {
            alertSC.classList.replace('flex','hidden');  
        })
    </script>
<?php unset($_SESSION['successCart']); } ?>

