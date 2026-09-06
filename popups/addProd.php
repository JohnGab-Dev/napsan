<div class="bg1 addProd hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center px-4">

    <form action="api/ProductController.php" method="POST" 
        class="w-full max-w-4xl bg-white rounded-xl shadow-2xl p-8 flex flex-col gap-6 animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-lg font-semibold">Add New Product</h1>
                <p class="text-sm text-gray-500">Fill in product details</p>
            </div>

            <button onclick="closeModal()" type="button" class="cl-add text-xl font-bold hover:text-red-500 transition">&times;</button>
        </div>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- LEFT -->
            <div class="flex flex-col gap-4">

                <div>
                    <label class="text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" required autofocus
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="qty" min="0" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Expiry Date</label>
                    <?php
                        date_default_timezone_set('Asia/Manila');
                        $today = date('Y-m-d');
                    ?>
                    <input type="date" name="expiry" min="<?= $today?>" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Stock Alert Level</label>
                    <input type="number" name="level" min="0" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex flex-col gap-4">

                <div>
                    <label class="text-sm font-medium text-gray-700">Distributor</label>
                    <input type="text" name="distrib" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">SRP (PHP)</label>
                    <input type="number" name="srp" step="any" min="0" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Capital (PHP)</label>
                    <input type="number" name="capital" step="any" min="0" required
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 pt-4 border-t">
            <button onclick="cancelCoseModal()" type="button" class="cl-add px-4 py-2 rounded-md border hover:bg-gray-100">
                Cancel
            </button>

            <button type="submit" name="addProd"
                class="px-5 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">
                Add Product
            </button>
        </div>

    </form>
</div>

<script>
    
    function openModal(){
        const addProd = document.querySelector(".addProd");
        addProd.classList.remove("hidden");
        addProd.classList.add("flex");
    }

    function cancelCoseModal(){
        const addProd = document.querySelector(".addProd");
        addProd.classList.remove("flex");
        addProd.classList.add("hidden");
    }

    function closeModal(){

        const addProd = document.querySelector(".addProd");
        addProd.classList.remove("flex");
        addProd.classList.add("hidden");
    }
</script>