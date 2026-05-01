<?php
session_start();
$title = "Napsan Pharmacy || Edit Transaction";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'components/navCashier.php';
require 'components/sidebar.php';
require 'popups/notif.php';
require 'popups/profile.php';
require 'popups/alerts.php';

$trId = mysqli_real_escape_string($con, $_GET['id']);
$query = "SELECT * FROM transactions WHERE transId = '$trId'";
$run_query = mysqli_query($con, $query);
$row = mysqli_fetch_array($run_query);

$created_date = $row['created_at'];
$datetime = new DateTime($created_date);
$created_date = $datetime->format('F d, Y h:i A');
?>

    <div class="w-full min-h-screen pt-20 px-4 pb-4 flex justify-center">
        <div class="w-full max-w-6xl bg-white shadow-lg rounded-lg p-6 flex flex-col gap-6">

            <!-- HEADER -->
            <div class="flex justify-between items-center border-b pb-3">
                <h1 class="text-lg font-semibold">
                    Transaction #<?= $trId ?>
                </h1>
                <p class="text-sm text-gray-500"><?= $created_date ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- LEFT: PRODUCTS -->
                <div class="flex flex-col">

                    <h2 class="text-md font-semibold mb-2">Purchased Items</h2>

                    <div class="border rounded-lg overflow-hidden">
                        <table class="w-full text-left border-collapse">

                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="p-3">Product</th>
                                    <th class="p-3">Qty</th>
                                    <th class="p-3">SRP</th>
                                    <th class="p-3">Total</th>
                                    <th class="p-3">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 text-sm">
                                <?php
                                $query1 = "SELECT productsold.soldId, productsold.productId, productsold.qty as Cqty, productsold.srp, productsold.capital, productsold.total, products.name 
                                        FROM productsold 
                                        JOIN products ON productsold.productId = products.productId 
                                        WHERE transId = '$trId' 
                                        ORDER BY productsold.created_at DESC";

                                $run_query1 = mysqli_query($con, $query1);
                                $sub_total = 0;

                                if(mysqli_num_rows($run_query1)>0){
                                    while($row1 = mysqli_fetch_array($run_query1)){
                                        $sub_total += $row1['total'];
                                ?>

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-2 font-medium"><?= $row1['name'] ?></td>
                                    <td class="p-2"><?= $row1['Cqty'] ?></td>
                                    <td class="p-2">₱<?= number_format($row1['srp'],2) ?></td>
                                    <td class="p-2">₱<?= number_format($row1['total'],2) ?></td>
                                    <td class="p-2">
                                        <form action="api/TransactionController.php?id=<?= $row1['soldId']?>" method="post">
                                            <button type="submit" name="delSold"
                                                class="text-xs px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                                Return
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <?php }} else { ?>
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-gray-500">
                                            No products added
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RIGHT: SUMMARY -->
                <form action="api/TransactionController.php?id=<?= $trId;?>" method="post" 
                    class="flex flex-col gap-4">

                    <h2 class="text-md font-semibold">Payment Summary</h2>

                    <!-- SUBTOTAL -->
                    <div class="flex justify-between items-center">
                        <label class="font-medium">Subtotal</label>
                        <input type="text" name="subtotal"
                            class="sub text-right w-1/2 bg-gray-100 px-3 py-2 rounded-md border"
                            readonly
                            value="<?= number_format($sub_total, 2); ?>">
                    </div>

                    <!-- DISCOUNT -->
                    <div class="flex justify-between items-center">
                        <label class="font-medium">Discount</label>
                        <input type="number" step="any" name="discount"
                            class="dis w-1/2 px-3 py-2 rounded-md border focus:ring-2 focus:ring-green-500 outline-none"
                            value="<?= $row['discount'] ?>">
                    </div>

                    <!-- TOTAL -->
                    <div class="flex justify-between items-center">
                        <label class="font-semibold">Total</label>
                        <input type="text" name="total"
                            class="total text-right w-1/2 bg-gray-100 px-3 py-2 rounded-md border font-semibold"
                            readonly
                            value="<?= number_format($sub_total - $row['discount'], 2); ?>">
                    </div>

                    <!-- PAYMENT METHOD -->
                    <div class="flex flex-col gap-2">
                        <label class="font-medium">Payment Method</label>

                        <div class="flex gap-2">
                            <span class="px-3 py-1 rounded-full text-xs 
                                <?= $row['mode_of_payment'] == 'Cash' 
                                    ? 'bg-yellow-200 text-yellow-800' 
                                    : 'bg-blue-200 text-blue-800' ?>">
                                <?= $row['mode_of_payment'] ?>
                            </span>
                        </div>

                        <input type="text"
                            class="bg-gray-100 px-3 py-2 rounded-md border"
                            value="<?= $row['ref_num'] == 'N/A' ? 'No reference' : $row['ref_num'] ?>"
                            readonly>
                    </div>

                    <!-- TENDERED -->
                    <div class="flex justify-between items-center">
                        <label class="font-medium">Amount Tendered</label>
                        <input type="text"
                            class="text-right w-1/2 bg-gray-100 px-3 py-2 rounded-md border"
                            value="<?= number_format($row['tendered'],2) ?>"
                            readonly>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="transactions.php">
                            <button type="button"
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition">
                                Exit
                            </button>
                        </a>

                        <button type="submit" name="save"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition">
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    function parseFormattedNumber(value) {
        // Remove commas then convert to float
        return parseFloat(value.replace(/,/g, '')) || 0;
    }
    function formatNumber(value) {
        // Format number with 2 decimals and comma
        return value.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    const sub = document.querySelector(".sub");
    const dis = document.querySelector(".dis");
    const total = document.querySelector(".total");

    function updateTotal() {
        const subValue = parseFormattedNumber(sub.value) || 0;
        const disValue = parseFormattedNumber(dis.value) || 0;
        const newTotal = subValue - disValue;
        total.value = formatNumber(newTotal);
    }

    sub.addEventListener("input", updateTotal);
    dis.addEventListener("input", updateTotal);
});
    function editSold(n){
        const editSold = document.querySelector(".editSold" + n);
        if (editSold) {
            editSold.classList.replace('hidden', 'flex');
        }
    }

    function closeEdit(n){    
        const editSold = document.querySelector(".editSold" + n);
        if (editSold) {
            editSold.classList.replace('flex', 'hidden');
        }
    }
</script>

<?php include 'partials/__footer.php'; ?>