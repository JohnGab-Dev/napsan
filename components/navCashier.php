<?php
    $query11 = "SELECT * FROM notification WHERE status = 'UNREAD'";
    $run_query11 = mysqli_query($con, $query11);
    $num = mysqli_num_rows($run_query11);
?>
<nav class="w-full h-10 bg-white flex items-center px-10 border-b justify-between fixed top-0">
    <div class="w-auto h-auto flex gap-1 items-center">
        <img src="imgs/menu.png" alt="" class="btn-nav w-7 h-7 p-1 cursor-pointer hover:bg-slate-100 active:opacity-80">
        <a href="" class=" font-bold text-red-600"><span class="text-green-700">N</span>APSAN Pharmacy</a>
    </div>
    

    <div class="w-auto h-auto flex gap-1 items-center">
        <div class="notiftoggle px-2 py-1 flex items-center cursor-pointer hover:bg-slate-100 active:bg-sky-100">
            <img src="imgs/notification.png" alt="" class="w-6 h-6">
            <p class="text-sm text-red-600 font-semibold"><?= $num == 0 ? '' : $num?></p>
        </div>

        
        
        <div class="user px-2 py-1 flex items-center gap-1 cursor-pointer hover:bg-slate-100 active:bg-sky-100">
            <img src="imgs/user.png" alt="" class=" w-6 h-6">
            <img src="imgs/down.png" alt="" class=" w-3 h-3">
        </div>
        
    </div>
</nav>

