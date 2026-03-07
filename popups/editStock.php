<div class="bg1 editStock<?= $row['stId']?> hidden w-full h-screen z-50 items-center justify-center absolute top-0 right-0 left-0">
    <form action="api/ProductController.php?id=<?= $row['stId']?>" method="POST" class="w-2/5 h-5/5 bg-white rounded-sm p-5 flex flex-col gap-4">
        <div class="w-full h-auto flex justify-between">
            <div>
                <h1 class="font-medium">Edit a batch of stocks</h1>
                <h1 class="font-medium text-sm underline">for <?= $row['name']?></h1>
                <p class="text-xs">Please fill all fields</p>
            </div>
            <img src="imgs/close-n.png" onclick="closeEdit(<?= $row['stId']?>)" alt="" class=" w-7 h-7 p-2 cursor-pointer rounded-sm hover:bg-slate-100 active:opacity-80">
        </div>
        <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert flex w-full h-5/5 bg-red-200 border-l-4 border-red-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['error'];?></h1>
                    <button type="button" class="close<?= $row['stId']?> p-1 hover:bg-slate-100 active:opacity-80"><img src="imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
                <script>
                    const alert = document.querySelector(".alert");
                    const close = document.querySelector(".close");

                    close.addEventListener("click", ()=> {
                        alert.classList.replace('flex','hidden');
                    })
                </script>
        <?php unset($_SESSION['error']); }?>

                <div class="">
                    <label for="qty">QTY</label>
                    <input type="number" min="0" name="qty" id="qty" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required value="<?= $row['stocks_in']?>">
                </div>

                <div class="">
                    <label for="expiry">Expiry(Optional)</label>
                    <?php
                        date_default_timezone_set('Asia/Manila');
                        $today = date('Y-m-d');
                    ?>
                    <input type="date" min="<?= $today?>" name="expiry" id="expiry" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" value="<?= $row['expiry']?>" required>
                </div>

        <div class="w-full flex justify-end">
            <button type="submit" name="editStock" class=" px-4 h-8 bg-green-600 text-white font-semibold hover:bg-green-700 active:opacity-80">Save Changes</button>
        </div>
        
    </form>
</div>
