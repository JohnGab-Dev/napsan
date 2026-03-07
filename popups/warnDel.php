<div class="bg1 delProd<?= $row['productId']?> hidden w-full h-screen z-50 items-center justify-center absolute top-0 right-0 left-0">
    <form action="api/ProductController.php?id=<?= $row['productId']?>" method="POST" class="w-2/6 h-5/5 bg-white rounded-sm p-5 flex flex-col gap-4">
        <div class="w-full h-auto flex justify-between">
            <div class="w-full py-2 bg-red-200 rounded-sm border-l-4 border-red-600 px-4">
                <h1 class="font-medium text-lg">Warning</h1>
                <p class="text-xs">If you delete this.....theres no turning back!</p>
            </div>
        </div>
        <h1 class="text-2xl font-medium text-center">Are you sure you want to delete Product <?= $row['name'];?> ?</h1>
        <div class="w-full flex justify-end items-center gap-4 mt-5">
            <button type="button" onclick="closeDel(<?= $row['productId']?>)" class="py-3 px-6 bg-neutral-600 text-white font-semibold hover:bg-neutral-700 active:opacity-80 text-lg rounded-sm">No</button>
            <button type="submit" name="delProd" class=" py-3 px-6 text-lg  bg-red-600 text-white font-semibold hover:bg-red-700 active:opacity-80 rounded-sm">Yes</button>
        </div>
        
    </form>
</div>
