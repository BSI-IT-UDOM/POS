<!-- Popup form -->
<div id="editTablePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">EDIT TABLE</h2>
        </div>
        <form id="editTableForm" action="" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')
            <input type="hidden" id="editpos_table_id" name="pos_table_id">
            <div class="mb-4">
                <label for="edittable_number" class="block text-sm font-medium text-gray-900 mb-1">NUMBER</label>
                <input type="text" id="edittable_number" name="table_number" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('table_number')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="mb-4">
                <label for="edittable_name" class="block text-sm font-medium text-gray-900 mb-1">NAME</label>
                <input type="text" id="edittable_name" name="table_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('table_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="mb-4">
                <label for="edittable_location" class="block text-sm font-medium text-gray-900 mb-1">LOCATION</label>
                <input type="text" id="edittable_location" name="table_location" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('table_location')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closeeditTablePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('closeeditTablePopup').addEventListener('click', function() {
        document.getElementById('editTablePopup').classList.add('hidden');
        document.getElementById('editTableForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('editTablePopup').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }
</script>