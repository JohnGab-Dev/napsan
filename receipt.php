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
<div class="w-full h-auto flex items-center justify-center flex-col gap-4 pt-4">
    <div class="receipt w-[24rem] h-5/5 bg-white px-4 py-4 text-xs">
        <h1>NAPSAN PHARMACY</h1>
        <h1>Poblacion, San Ildefonso, Bulacan</h1>
        <h1 class="mt-2">Transaction No. <?= $row['transId'] ?></h1>
        <h1 class="mb-2"><?= $created_date ?></h1>

        <div class="w-full border border-black mb-2"></div>

        <h1 class="text-center">Transaction Receipt</h1>

        <table class="w-full mt-2">
            <thead>
                <tr>
                    <th class="font-medium text-left ">Name</th>
                    <th class="font-medium text-left ">QTY</th>
                    <th class="font-medium text-left ">SRP</th>
                    <th class="font-medium text-left ">Amount</th>
                </tr>
            </thead>
            <tbody class="text-xs">
                <?php
                $query1 = "SELECT productsold.soldId, productsold.productId, productsold.transId, productsold.qty as s_qty, productsold.srp as s_srp, productsold.total, products.name FROM productsold JOIN products ON productsold.productID = products.productId WHERE transId = '$trId' ORDER BY productsold.created_at DESC";
                $run_query1 = mysqli_query($con, $query1);
                if (mysqli_num_rows($run_query1) > 0) {
                    while ($row1 = mysqli_fetch_array($run_query1)) {

                ?>
                <tr>
                    <td class="py-1"><?= $row1['name']?></td>
                    <td class="py-1"><?= $row1['s_qty']?></td>
                    <td class="py-1">P<?= $row1['s_srp']?></td>
                    <td class="py-1">P<?= $row1['total']?></td>
                </tr>

                <?php
                    }
                }else{
                ?>

                <tr class="text-center">
                        <td colspan="4" class="p-1 font-medium">No Sold Products Found! <br>You might have deleted the records!</td>
                    </tr>
                <?php }?>

                <tr class="border-t font-medium pt-2">
                    <td class="py-1" colspan="3">SUB-TOTAL:</td>
                    <td class="py-1">P<?= $row['subtotal'] ?></td>
                </tr>
                <tr class="font-medium">
                    <td class="py-1" colspan="3">DISCOUNT:</td>
                    <td class="py-1">P<?= $row['discount'] ?></td>
                </tr>
                <tr class="font-medium">
                    <td class="py-1" colspan="3">TOTAL:</td>
                    <td class="py-1">P<?= $row['total'] ?></td>
                </tr>
                <tr class="font-medium">
                    <td class="py-1 " colspan="3">AMOUNT TENDERED:</td>
                    <td class="py-1">P<?= $row['tendered'] ?></td>
                </tr>

                <tr class="border-b border-black font-medium">
                    <td class="py-1" colspan="3">CHANGE:</td>
                    <?php
                    $change = $row['tendered'] - $row['total'];
                    $change = number_format($change, 2);
                    ?>
                    <td class="py-1">P<?= $change ?></td>
                </tr>

            </tbody>
        </table>

        <h1 class="text-center mt-2">Thanks for buying at our store!</h1>
        <h1 class="text-center">See you again!</h1>
    </div>

    <div class="btns w-[20rem] h-auto flex items-center flex-col text-sm gap-2 text-white">
        <button type="button" onclick="window.print()" class="btns px-2 py-1 rounded-sm bg-neutral-400 hover:bg-neutral-500 active:opacity-80 font-medium">Print Receipt</button>
        <a href="pos.php"><button class="btns px-2 py-1 rounded-sm bg-green-400 hover:bg-green-500 active:opacity-80 font-medium ">Make Another Transaction</button></a>
    </div>

</div>


<?php include 'partials/__footer.php'; ?>