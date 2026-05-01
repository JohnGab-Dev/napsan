<form action="api/TransactionController.php" method="POST" 
class="filter hidden flex-col absolute z-50 top-40 left-[17rem] w-[22rem] bg-white shadow-xl border border-gray-200 rounded-xl p-5 gap-4">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="font-semibold text-gray-700">Filter by Date</h1>
        
    </div>

    <!-- Date Input -->
    <div class="flex flex-col gap-1">
        <label class="text-sm text-gray-500">Select Date</label>
        <input 
            type="date" 
            name="date" 
            class="w-full rounded-lg border border-gray-300 px-3 py-2 
                   focus:ring-2 focus:ring-green-500 focus:outline-none 
                   transition"
        >
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-2 mt-2">
        <a href="tr_history.php">
            <button 
                type="button"  
                class="px-4 py-2 bg-gray-500 text-white rounded-md 
                       hover:bg-gray-600 transition font-medium">
                Clear
            </button>
        </a>

        <button 
            type="submit" 
            name="date_filter" 
            class="px-4 py-2 bg-green-600 text-white rounded-md 
                   hover:bg-green-700 transition font-medium">
            Apply
        </button>
    </div>
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