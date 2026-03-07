<div class="prof w-[11rem] h-5/5 flex-col absolute z-50 top-10 right-10 bg-white shadow-lg border rounded-sm p-1">
    <p class="w-full h-auto flex items-center bg-slate-100 py-2 px-2 gap-2 font-medium"><img src="imgs/user.png" class="w-7 h-7"/><?= $_SESSION['user']['username']?></p>

    <?php if($_SESSION['user']['role'] == 'admin'){?>
        <a href="settings.php" class="w-full h-auto flex items-center hover:bg-slate-100 py-2 px-2 gap-2 font-medium active:opacity-80"><img src="imgs/setting.png" class="w-7 h-7"/>Settings</a>
    <?php } ?>
    
    <a href="logout/logout.php" class="w-full h-auto flex items-center hover:bg-slate-100 py-2 px-2 gap-2 font-medium active:opacity-80"><img src="imgs/logout.png" class="w-7 h-7"/>Logout</a>

</div>


<script>
    const prof = document.querySelector(".prof");
    const user = document.querySelector(".user");

    user.addEventListener("click", () => {
        prof.classList.toggle("active");
    });

    window.addEventListener("click", (event) => {
        if (!prof.contains(event.target) && !user.contains(event.target)) {
            prof.classList.remove("active");
        }
    }); 

</script>