<div class="bg1 addStock<?= $row['productId']?> hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center px-4">

    <form action="api/ProductController.php?id=<?= $row['productId']?>" method="POST" 
        class="w-full max-w-xl bg-white rounded-xl shadow-2xl p-6 flex flex-col gap-6 animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <div>
                <h1 class="text-lg font-semibold">Add Stock</h1>
                <p class="text-sm text-gray-500">for <?= $row['name']?></p>
            </div>

            <button type="button" onclick="closeAdd(<?= $row['productId']?>)" 
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

        <!-- Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Quantity -->
            <div class="flex flex-col gap-1">
                <label class="text-sm text-gray-600">Quantity</label>
                <input type="number" name="qty" min="0" required
                    class="rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 
                    focus:ring-2 focus:ring-green-500 focus:outline-none transition">
            </div>

            <!-- Expiry -->
            <div class="flex flex-col gap-1">
                <label class="text-sm text-gray-600">Expiry Date</label>
                <?php
                    date_default_timezone_set('Asia/Manila');
                    $today = date('Y-m-d');
                ?>
                <input type="date" name="expiry" min="<?= $today?>" required
                    class="rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 
                    focus:ring-2 focus:ring-green-500 focus:outline-none transition">
            </div>

            <!-- SRP -->
            <div class="flex flex-col gap-1">
                <label class="text-sm text-gray-600">New SRP (PHP)</label>
                <input type="number" name="srp" step="any" min="0" value="<?= $row['srp']?>" required
                    class="rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 
                    focus:ring-2 focus:ring-green-500 focus:outline-none transition">
            </div>

            <!-- Capital -->
            <div class="flex flex-col gap-1">
                <label class="text-sm text-gray-600">New Capital (PHP)</label>
                <input type="number" name="capital" step="any" min="0" value="<?= $row['capital']?>" required
                    class="rounded-lg border border-gray-300 px-4 py-2 bg-gray-100 
                    focus:ring-2 focus:ring-green-500 focus:outline-none transition">
            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 pt-4 border-t">
            <button type="button" onclick="closeAdd(<?= $row['productId']?>)" 
                class="px-4 py-2 rounded-md border hover:bg-gray-100">
                Cancel
            </button>

            <button type="submit" name="addStock"
                class="px-5 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">
                Add Stock
            </button>
        </div>

    </form>
</div>