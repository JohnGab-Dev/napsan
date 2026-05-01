<div class="bg1 delNotifui hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 items-center justify-center px-4">

    <form action="api/SettingsController.php" method="POST"
        class="w-full max-w-md bg-white rounded-xl shadow-2xl p-6 flex flex-col gap-6 animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <h1 class="text-lg font-semibold text-red-600">Delete Notifications</h1>

            <button type="button" onclick="closeDel()" class="delclose text-xl font-bold hover:text-red-500 transition">
                &times;
            </button>
        </div>

        <!-- Warning Box -->
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-md text-sm">
            <strong>Warning:</strong> This will permanently delete all notifications. This action cannot be undone.
        </div>

        <!-- Confirmation Text -->
        <div class="text-center">
            <h2 class="text-lg font-medium text-gray-700">
                Are you sure you want to proceed?
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                All notification records will be removed permanently.
            </p>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-2 pt-4 border-t">
            <button type="button" onclick="closeDel()" class="delclose px-4 py-2 rounded-md border hover:bg-gray-100">
                Cancel
            </button>

            <button type="submit" name="delNotifAll"
                class="px-5 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700 transition">
                Delete All
            </button>
        </div>

    </form>
</div>