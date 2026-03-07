<div class="bg1 addProd w-full h-screen z-50 items-center justify-center absolute top-0">
    <form action="api/ProductController.php" method="POST" class="w-3/5 h-5/5 bg-white rounded-sm p-5 flex flex-col gap-4">
        <div class="w-full h-auto flex justify-between">
            <div>
                <h1 class="font-medium">Add a New Product</h1>
                <p class="text-xs">Please fill all fields</p>
            </div>
            <img src="imgs/close-n.png" alt="" class="cl-add w-7 h-7 p-2 cursor-pointer rounded-sm hover:bg-slate-100 active:opacity-80">
        </div>
        <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert flex w-full h-5/5 bg-red-200 border-l-4 border-red-600 items-center justify-between px-2 text-sm p-1 rounded-sm">
                    <h1><?= $_SESSION['error'];?></h1>
                    <button type="button" class="close p-1 hover:bg-slate-100 active:opacity-80"><img src="/imgs/close-n.png" class="w-3 h-3" alt=""></button>
                </div>
                <script>
                    const alert = document.querySelector(".alert");
                    const close = document.querySelector(".close");

                    close.addEventListener("click", ()=> {
                        alert.classList.replace('flex','hidden');
                    })
                </script>
        <?php unset($_SESSION['error']); }?>

        <div class="w-full h-full flex gap-4">
            <div class="w-1/2 h-full flex flex-col gap-4">
                <div class="">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" autofocus required>
                </div>

                <div class="">
                    <label for="qty">QTY</label>
                    <input type="number" min="0" name="qty" id="qty" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>

                <div class="">
                    <label for="expiry">Expiry</label>
                    <?php
                        date_default_timezone_set('Asia/Manila');
                        $today = date('Y-m-d');
                    ?>
                    <input type="date" min="<?= $today?>" name="expiry" id="expiry" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>
                <div class="">
                    <label for="level">Level of Stocks before Notify</label>
                    <input type="number" min="0" name="level" id="level" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>

                
            </div>  

            <div class="w-1/2 h-full flex flex-col gap-4">

                <div class="">
                    <label for="distrib">Distributor</label>
                    <input type="text" name="distrib" id="distrib" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>

                <div class="">
                    <label for="srp">SRP(PHP)</label>
                    <input type="number" step="any" min="0" name="srp" id="srp" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>

                <div class="">
                    <label for="capital">Capital(PHP)</label>
                    <input type="number" step="any" min="0" name="capital" id="capital" class="w-full border h-10 text-lg outline-none px-1 border-black rounded-sm focus:border-2 focus:border-green-600" required>
                </div>

            </div>  
        </div>
        <div class="w-full flex justify-end">
            <button type="submit" name="addProd" class=" px-4 h-8 bg-green-600 text-white font-semibold hover:bg-green-700 active:opacity-80">Add Product</button>
        </div>
        
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const addProd = document.querySelector(".addProd");
        const add = document.querySelector(".add");
        const cl_add = document.querySelector(".cl-add");

        add.addEventListener("click", () => {
            addProd.classList.add("active");
        });

        cl_add.addEventListener("click", () => {
            addProd.classList.remove("active");
        });
    });

    

</script>