<div class="bg1 editProd<?= $row['productId']?> hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center px-4">

    <form action="api/ProductController.php?id=<?= $row['productId']?>" method="POST"
        class="w-full max-w-4xl bg-white rounded-xl shadow-2xl p-8 flex flex-col gap-6 animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-lg font-semibold">Edit Product</h1>
                <p class="text-sm text-gray-500">Update product details</p>
            </div>

            <button type="button" onclick="closeEdit(<?= $row['productId']?>)"
                class="text-xl font-bold hover:text-red-500 transition">
                &times;
            </button>
        </div>

        <!-- Alert -->
        <?php if(isset($_SESSION['error'])){ ?>
            <div class="flex items-center justify-between bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-2 rounded-md text-sm shadow-sm">
                <span><?= $_SESSION['error'];?></span>
                <button type="button" class="text-lg closeAlert">&times;</button>
            </div>
        <?php unset($_SESSION['error']); } ?>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- LEFT -->
            <div class="flex flex-col gap-4">

                <div>
                    <label class="text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" required autofocus
                        value="<?= $row['name']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="qty" min="0" required
                        value="<?= $row['qty']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Distributor</label>
                    <input type="text" name="distrib" required
                        value="<?= $row['distributor']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex flex-col gap-4">

                <div>
                    <label class="text-sm font-medium text-gray-700">SRP (PHP)</label>
                    <input type="number" name="srp" step="any" min="0" required
                        value="<?= $row['srp']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Capital (PHP)</label>
                    <input type="number" name="capital" step="any" min="0" required
                        value="<?= $row['capital']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Stock Alert Level</label>
                    <input type="number" name="level" min="0" required
                        value="<?= $row['level_notif']?>"
                        class="w-full border rounded-md px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-green-500 outline-none">
                </div>

            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 pt-4 border-t">
            <button type="button" onclick="closeEdit(<?= $row['productId']?>)"
                class="px-4 py-2 rounded-md border hover:bg-gray-100">
                Cancel
            </button>

            <button type="submit" name="editProd"
                class="px-5 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">
                Save Changes
            </button>
        </div>

    </form>
</div>
