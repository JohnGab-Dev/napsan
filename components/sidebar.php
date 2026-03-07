
<nav class="sidenav w-64 h-screen fixed top-0 bg-white shadow-xl p-4 flex flex-col text-gray-700 z-50">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-lg font-bold">
            <span class="text-gray-700">NAPSAN</span>
        </h1>

        <img src="imgs/close-n.png"
             class="close w-8 h-8 p-2 rounded-lg cursor-pointer hover:bg-[rgb(0,0,0,0.15)]">
    </div>


    <!-- LOGO -->
    <div class="flex justify-center mb-6">
        <img src="imgs/napsan_logo.jpg"
             class="w-32 h-20 rounded">
    </div>


    <!-- NAVIGATION -->
    <div class="flex flex-col gap-2 text-sm font-medium">

        <?php if($_SESSION['user']['role'] == 'admin'){ ?>
        <a href="dashboard.php"
           class="px-3 py-2 rounded transition
           <?= $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/dashboard.php'
           ? 'bg-green-600 text-white'
           : 'hover:bg-green-600 hover:text-white' ?>">
            Dashboard
        </a>
        <?php } ?>

        <a href="pos.php"
           class="px-3 py-2 rounded transition
           <?= $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/pos.php'
           ? 'bg-green-600 text-white'
           : 'hover:bg-green-600 hover:text-white' ?>">
            POS Overview
        </a>


        <a href="transactions.php"
           class="px-3 py-2 rounded transition
           <?= ($current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/transactions.php'
           || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/tr_history.php')
           ? 'bg-green-600 text-white'
           : 'hover:bg-green-600 hover:text-white' ?>">
            Transactions
        </a>


        <a href="inventory.php"
           class="px-3 py-2 rounded transition
           <?= ($current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/inventory.php'
           || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/stocks.php'
           || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/low_stock.php'
           || $current_url == 'http://' . $_SERVER['HTTP_HOST'] . '/napsan_management/expiring.php')
           ? 'bg-green-600 text-white'
           : 'hover:bg-green-600 hover:text-white' ?>">
            Inventory
        </a>

    </div>


    <!-- FOOTER -->
    <div class="mt-auto pt-6 border-t border-green-400 text-xs text-center">
        <p>NAPSAN Pharmacy</p>
        <p>POS & Inventory System</p>
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