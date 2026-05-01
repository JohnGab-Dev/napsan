<?php if(isset($_SESSION['error'])){ ?>
    <div class="alertE flex fixed bottom-6 right-6 max-w-sm w-auto bg-red-500/90 backdrop-blur-md text-white items-center justify-between px-4 py-3 rounded-lg shadow-lg z-50 gap-3 animate-fadeIn">
        <div class="flex items-center gap-2">
            <span class="text-lg">❌</span>
            <p class="text-sm font-medium"><?= $_SESSION['error'];?></p>
        </div>
        <button type="button" class="closeE text-lg font-bold hover:opacity-70">&times;</button>
    </div>

    <script>
        const alertE = document.querySelector(".alertE");
        const closeE = document.querySelector(".closeE");

        closeE.addEventListener("click", ()=> {
            alertE.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertE.remove(), 300);
        });

        setTimeout(()=>{
            alertE.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertE.remove(), 300);
        }, 4000);
    </script>
<?php unset($_SESSION['error']); } 
else if(isset($_SESSION['success'])){?>

    <div class="alertM flex fixed bottom-6 right-6 max-w-sm w-auto bg-green-500/90 backdrop-blur-md text-white items-center justify-between px-4 py-3 rounded-lg shadow-lg z-50 gap-3 animate-fadeIn">
        <div class="flex items-center gap-2">
            <span class="text-lg">✅</span>
            <p class="text-sm font-medium"><?= $_SESSION['success'];?></p>
        </div>
        <button type="button" class="closeM text-lg font-bold hover:opacity-70">&times;</button>
    </div>

    <script>
        const alertS = document.querySelector(".alertM");
        const closeS = document.querySelector(".closeM");

        closeS.addEventListener("click", ()=> {
            alertS.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertS.remove(), 300);
        });

        setTimeout(()=>{
            alertS.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertS.remove(), 300);
        }, 4000);
    </script>

<?php unset($_SESSION['success']); } ?>

<?php if(isset($_SESSION['errorCart'])){ ?>
    <div class="alertEC flex fixed top-[4rem] right-6 max-w-sm w-auto bg-red-500/90 backdrop-blur-md text-white items-center justify-between px-4 py-3 rounded-lg shadow-lg z-50 gap-3 animate-fadeIn">
        <div class="flex items-center gap-2">
            <span class="text-lg">❌</span>
            <p class="text-sm font-medium"><?= $_SESSION['errorCart'];?></p>
        </div>
        <button type="button" class="closeEC text-lg font-bold hover:opacity-70">&times;</button>
    </div>

    <script>
        const alertEC = document.querySelector(".alertEC");
        const closeEC = document.querySelector(".closeEC");

        closeEC.addEventListener("click", ()=> {
            alertEC.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertEC.remove(), 300);
        });

        setTimeout(()=>{
            alertEC.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertEC.remove(), 300);
        }, 4000);
    </script>

<?php unset($_SESSION['errorCart']); } 
else if(isset($_SESSION['successCart'])){?>

    <div class="alertMC flex fixed top-[4rem] right-6 max-w-sm w-auto bg-green-500/90 backdrop-blur-md text-white items-center justify-between px-4 py-3 rounded-lg shadow-lg z-50 gap-3 animate-fadeIn">
        <div class="flex items-center gap-2">
            <span class="text-lg">✅</span>
            <p class="text-sm font-medium"><?= $_SESSION['successCart'];?></p>
        </div>
        <button type="button" class="closeMC text-lg font-bold hover:opacity-70">&times;</button>
    </div>

    <script>
        const alertSC = document.querySelector(".alertMC");
        const closeSC = document.querySelector(".closeMC");

        closeSC.addEventListener("click", ()=> {
            alertSC.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertSC.remove(), 300);
        });

        setTimeout(()=>{
            alertSC.classList.add('opacity-0','translate-y-2');
            setTimeout(()=> alertSC.remove(), 300);
        }, 4000);
    </script>

<?php unset($_SESSION['successCart']); } ?>