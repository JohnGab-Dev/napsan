<form action="api/TransactionController.php" method="POST" class="filter w-[20rem] h-5/5 flex-col absolute z-50 top-24 left-[17rem] bg-white shadow-lg border rounded-sm p-4 gap-4">
    <h1 class="w-full h-auto bg-white font-medium">Search for a date show</h1>
    
    <input type="date" name="date" class="w-full outline-none h-10 border border-black px-1 focus:border-2 focus:border-green-600">
    <button type="submit" name="date_filter" class="px-2 py-1 rounded-sm bg-blue-600 text-white hover:bg-blue-700 active:opacity-80">Filter</button>
    <a href="tr_history.php"><button type="button"  class="px-2 py-1 rounded-sm bg-neutral-600 text-white hover:bg-neutral-700 active:opacity-80">Clear Filter</button></a>
</form>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const filter = document.querySelector(".filter");
    const trig_filt = document.querySelector(".trig");

    trig_filt.addEventListener("click", () => {
        filter.classList.toggle("active");
    });

    window.addEventListener("click", (event) => {
        if (!filter.contains(event.target) && !trig_filt.contains(event.target)) {
            filter.classList.remove("active");
        }
    });
});
</script>