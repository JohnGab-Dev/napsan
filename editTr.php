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

<div class="w-full h-screen pt-10 p-2 flex gap-2 justify-center">
    <div class="w-1/2 h-full bg-white flex flex-col gap-4 flex-shrink-0">
            <div class="w-full h-1/2 border-b p-4">
                <div class="w-full h-auto py-1 bg-white flex justify-between items-center">
                    <h1 class="font-semibold">Transaction # <?= $trId?></h1>
                    <h1 class="font-semibold"><?= $created_date?></h1>
                </div>
                <div class="w-full h-[90%] overflow-y-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-white bg-green-600">
                                <th class="p-1 text-left">Product Name </th>
                                <th class="p-1 text-left">QTY </th>
                                <th class="p-1 text-left">SRP </th>
                                <th class="p-1 text-left">Total </th>
                                <th class="p-1 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium">

                        <?php
                            $query1 = "SELECT productsold.soldId, productsold.productId, productsold.qty as Cqty, productsold.srp, productsold.capital, productsold.total, products.name FROM productsold JOIN products ON productsold.productId = products.productId WHERE transId = '$trId' ORDER BY productsold.created_at DESC";
                            $run_query1 = mysqli_query($con, $query1);
                            $sub_total = 0;

                            if(mysqli_num_rows($run_query1)>0){
                                while($row1 = mysqli_fetch_array($run_query1)){
                                    $sub_total = $sub_total + $row1['total'];
                        ?>
                            
                            <tr class="border-b border-slate-400 hover:bg-slate-100">
                                <td class="p-1"><?= $row1['name']?></td>
                                <td class="p-1"><?= $row1['Cqty']?></td>
                                <td class="p-1">P<?= $row1['srp']?></td>
                                <td class="p-1">
                                    P<?= $row1['total']?>
                                </td>
                                <td class="p-1 flex items-center gap-1"> 
                                    <form action="api/TransactionController.php?id=<?= $row1['soldId']?>" method="post">
                                        <button type="submit" name="delSold" class="text-xs p-1 rounded-sm bg-red-600 hover:bg-red-700 text-white active:opacity-80">Return</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            }else{
                        ?>
                        <tr class="text-center">
                            <td colspan="5" class="p-1 font-medium py-1">No Products added</td>
                        </tr>
                    <?php }?> 
                            
                        </tbody>
                    </table>

                </div>
                
                
            </div>
            <form action="api/TransactionController.php?id=<?= $trId;?>" method="post" class="w-full h-1/2 flex flex-col px-4 gap-2">
                <div class="w-full h-auto flex justify-between items-center">
                    <label for="" class="font-semibold">SUB-TOTAL(PHP):</label>
                    <input type="text" step="any" name="subtotal" class="sub text-right py-1 outline-none w-4/6 border font-medium mr-12 bg-slate-100 px-2" readonly value="<?= number_format($sub_total, 2);?>" required>
                </div>

                <div class="w-full h-auto flex justify-between items-center gap-2">
                    <label for="" class="font-semibold">DISCOUNT(PHP):</label>
                    <input type="number" step="any" name="discount" class="dis border border-black rounded-sm px-2 py-1 outline-none w-4/5 h-8 font-medium mr-12 focus:border-2 focus:border-green-600" value="<?= $row['discount']?>">
                </div>

                <div class="w-full h-auto flex justify-between items-center">
                    <label for="" class="font-semibold">TOTAL(PHP):</label>
                    <input type="text" step="any" name="total" class="total text-right py-1 outline-none w-4/6 border font-medium mr-12 bg-slate-100 px-2" readonly value="<?= number_format($sub_total - $row['discount'], 2) ;?>" required>
                </div>

                <div class="w-full h-auto flex items-center gap-2">
                    <h1 class="font-medium">Payment Methods:</h1>
                    <input type="radio" name="methods" class="hidden" id="method1" required value="Cash" <?= $row['mode_of_payment'] == 'Cash' ? 'checked' : ''?> disabled>
                    <label for="method1" class="method px-2 py-1 border rounded-sm hover:bg-green-100 cursor-pointer font-medium" id="method1"  >CASH</label>

                    <input type="radio" name="methods" class="hidden" id="method2" required value="Gcash" <?= $row['mode_of_payment'] == 'Gcash' ? 'checked' : ''?> disabled>
                    <label for="method2" class="method px-2 py-1 border rounded-sm hover:bg-green-100 cursor-pointer font-medium" id="method2">G-CASH</label>

                    <input type="number" name="refnum" class=" bg-slate-100 rounded-sm px-2 py-1 outline-none w-[14rem] h-8 font-medium mr-12" placeholder="Ref. num(if gcash)" value="<?= $row['ref_num'] == 'N/A' ? '' : $row['ref_num']?>" readonly>
                </div>

                <div class="w-full h-auto flex justify-between items-center gap-2">
                    <label for=""  class="font-semibold">AMOUNT TENDERED(PHP):</label>
                    <input type="text" step="any" name="amount" class="sub text-right py-1 outline-none w-11/12 border font-medium mr-12 bg-slate-100 px-2" readonly value="<?= $row['tendered']?>" required>
                </div>
                

                <div class="w-full h-auto flex justify-end items-center gap-4">
                    <a href="transactions.php"><button type="button" class="px-3 py-1 rounded-sm bg-neutral-600 hover:bg-neutral-700 text-white font-medium active:opacity-80">Exit</button></a>
                    <button type="submit" name="save" class="px-2 py-1 rounded-sm bg-green-600 hover:bg-green-700 text-white font-medium active:opacity-80">Save Changes</button>
                </div>
            </form>
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