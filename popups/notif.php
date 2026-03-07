<div class="notif w-[25rem] h-[20rem] flex-col absolute z-50 top-10 right-10 bg-white shadow-lg border rounded-sm px-1 pb-1 overflow-y-auto">
    <div class="w-full py-1 flex items-center justify-between px-2 sticky top-0 bg-white">
        <h1 class="bg-white font-medium">Notifications</h1>
        <a href="api/notifController.php" class="text-sm font-medium text-blue-600 hover:underline">Mark all as read</a>
    </div>
    
    <?php
        $query11 = "SELECT * FROM notification ORDER BY created_at DESC LIMIT 50";
        $run_query11 = mysqli_query($con, $query11);

        if(mysqli_num_rows($run_query11)>0){
            while($row = mysqli_fetch_array($run_query11)){
    ?>
        <a href="api/notifController.php?id=<?= $row['notifId']?>" class="w-full h-auto border-y <?= $row['status'] == 'UNREAD' ? 'bg-slate-100' : ''?> flex items-center hover:bg-slate-100 py-2 px-2 gap-2 font-medium active:opacity-80"><img src="imgs/<?= $row['category'] == 'Expiry' ? 'time' : 'out-of-stock'?>.png" class="w-7 h-7"/>
        <h1><?= $row['title']?> <br><span class="text-xs text-neutral-700"><?= $row['description']?></span></h1></a>
    <?php
         }}else{
    ?>
    <p class="w-full h-auto text-center py-4">No notifications yet</p>
    <?php }?>


</div>

<script>
    const notif = document.querySelector(".notif");
    const notif_toggle = document.querySelector(".notiftoggle");

    notif_toggle.addEventListener("click", () => {
        notif.classList.toggle("active");
    });

    window.addEventListener("click", (event) => {
        if (!notif.contains(event.target) && !notif_toggle.contains(event.target)) {
            notif.classList.remove("active");
        }
    }); 

</script>