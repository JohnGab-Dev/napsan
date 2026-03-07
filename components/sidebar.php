
<nav class="sidenav w-[20%] h-screen fixed top-0 z-20 bg-green-600 shadow-lg p-4 flex flex-col gap-4 text-white font-medium">
    <div class="w-full h-auto flex justify-end">
        <img src="imgs/close-n.png" alt="" class="close w-8 h-8 px-2 py-2 hover:bg-slate-100 cursor-pointer rounded-sm duration-300 active:opacity-80">
    </div>
    
    <img src="imgs/napsan_logo.jpg" alt="" class="w-full h-20 rounded-sm mb-10">
    <div class="w-full h-auto flex flex-col gap-1">

    <?php if($_SESSION['user']['role'] == 'admin'){?>
       <a href= "dashboard.php" class="w-full py-2 px-2 hover:bg-white hover:text-black rounded duration-300 <?= $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/dashboard.php' ? 'text-black bg-white' : ''?>">Dashboard</a>
    <?php } ?>
    
    <a href="pos.php" class="w-full py-2 px-2 hover:bg-white hover:text-black rounded duration-300 <?= $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/pos.php' ? 'text-black bg-white' : ''?>">POS Overview</a>

    
        <a href="transactions.php" class="w-full py-2 px-2 hover:bg-white hover:text-black rounded duration-300 <?= ($current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/transactions.php' || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/tr_history.php') ? 'text-black bg-white' : ''?>">Transactions</a>
        <a href="inventory.php" class="w-full py-2 px-2 hover:bg-white hover:text-black rounded duration-300 <?= ($current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/inventory.php' || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/stocks.php' || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/low_stock.php' || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/expiring.php') ? 'text-black bg-white' : ''?>">Inventory</a>
    </div>
    
</nav>

<script>
    const sidenav = document.querySelector(".sidenav");
    const btn_nav = document.querySelector(".btn-nav");
    const close = document.querySelector(".close");
      
    btn_nav.addEventListener("click", ()=> {
        sidenav.classList.add("active");
    })

    close.addEventListener("click", ()=> {
        sidenav.classList.remove("active");
    })

    window.addEventListener("click", (event)=> {
    if (event.target !== sidenav && event.target !== btn_nav) {
        sidenav.classList.remove("active");
        event.stopPropagation;
    }
    })

</script>