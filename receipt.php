<?php
session_start();
$title = "Napsan Pharmacy || Receipt";
include 'partials/__header.php';
include 'methods/url.php';
include 'methods/userMidd.php';
include 'config/dbcon.php';

require 'methods/expiryMethod.php';

$trId = mysqli_real_escape_string($con, $_GET['id']);
$query = "SELECT * FROM transactions WHERE transId = '$trId'";
$run_query = mysqli_query($con, $query);
$row = mysqli_fetch_array($run_query);

$created_date = $row['created_at'];
$datetime = new DateTime($created_date);
$created_date = $datetime->format('F d, Y h:i A');
?>
<div class="w-full h-auto flex items-center justify-center flex-col gap-4 p-4 bg-gray-50 min-h-screen px-64">
    <div class="receipt w-full bg-white px-6 py-4  rounded-xl border border-gray-200">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold text-green-700">NAPSAN PHARMACY</h1>
            <p class="text-gray-600 text-sm">Poblacion, San Ildefonso, Bulacan</p>
            <div class="mt-2 text-gray-700">
                <p>Transaction No. <span class="font-medium"><?= $row['transId'] ?></span></p>
                <p><?= $created_date ?></p>
            </div>
        </div>

        <hr class="border-gray-300 mb-4">

        <h2 class="text-center font-semibold text-gray-800 mb-2">Transaction Receipt</h2>

        <!-- Items Table -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-700 border-b border-gray-300">
                    <th class="py-2">Name</th>
                    <th class="py-2">QTY</th>
                    <th class="py-2">SRP</th>
                    <th class="py-2">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query1 = "SELECT productsold.soldId, productsold.productId, productsold.transId, productsold.qty as s_qty, productsold.srp as s_srp, productsold.total, products.name 
                           FROM productsold 
                           JOIN products ON productsold.productID = products.productId 
                           WHERE transId = '$trId' ORDER BY productsold.created_at DESC";
                $run_query1 = mysqli_query($con, $query1);
                if (mysqli_num_rows($run_query1) > 0) {
                    while ($row1 = mysqli_fetch_array($run_query1)) {
                ?>
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-2"><?= $row1['name']?></td>
                    <td class="py-2"><?= $row1['s_qty']?></td>
                    <td class="py-2">P<?= number_format($row1['s_srp'],2)?></td>
                    <td class="py-2">P<?= number_format($row1['total'],2)?></td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="4" class="text-center py-2 text-gray-500">No Sold Products Found!</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="mt-4 text-gray-700">
            <div class="flex justify-between py-1 border-t border-gray-300">
                <span>SUB-TOTAL:</span>
                <span>P<?= number_format($row['subtotal'],2)?></span>
            </div>
            <div class="flex justify-between py-1">
                <span>DISCOUNT:</span>
                <span>P<?= number_format($row['discount'],2)?></span>
            </div>
            <div class="flex justify-between py-1 font-semibold text-gray-800">
                <span>TOTAL:</span>
                <span>P<?= number_format($row['total'],2)?></span>
            </div>
            <div class="flex justify-between py-1">
                <span>AMOUNT TENDERED:</span>
                <span>P<?= number_format($row['tendered'],2)?></span>
            </div>
            <div class="flex justify-between py-1 border-b border-gray-300 font-semibold">
                <span>CHANGE:</span>
                <span>P<?= number_format($row['tendered'] - $row['total'],2)?></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4 text-gray-600">
            <p>Thanks for buying at our store!</p>
            <p>See you again!</p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="btns w-80 flex flex-col gap-2 mt-4">
        <button type="button" onclick="window.print()" class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white font-medium active:opacity-80">Print Receipt</button>
        <a href="pos.php">
            <button class="w-full px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-medium active:opacity-80">Make Another Transaction</button>
        </a>
    </div>
</div>


<?php include 'partials/__footer.php'; ?>