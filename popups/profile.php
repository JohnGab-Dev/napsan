<div class="prof w-64 h-auto flex-col fixed z-50 top-12 right-10 bg-white shadow-lg border rounded-lg p-2">
    <div class="w-full h-auto flex items-center py-2 px-2 gap-2 font-medium">
        <img src="imgs/user.png" class="w-7 h-7"/>
        <p class="w-full h-auto flex flex-col px-2 font-medium"><?= $_SESSION['user']['username']?><span class="text-xs text-gray-700">User Options</span></p>
        
    </div>
    

    <?php if($_SESSION['user']['role'] == 'admin'){?>
        <a href="settings.php" class="w-full h-auto flex items-center hover:bg-slate-100 py-3 px-2 gap-2 font-medium active:opacity-80 rounded-lg"><img src="imgs/setting.png" class="w-7 h-7"/>Settings</a>
    <?php } ?>
    
    <a href="logout/logout.php" class="w-full h-auto flex items-center hover:bg-slate-100 py-3 px-2 gap-2 font-medium active:opacity-80 rounded-lg"><img src="imgs/logout.png" class="w-7 h-7"/>Logout</a>

</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
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
    });

</script>