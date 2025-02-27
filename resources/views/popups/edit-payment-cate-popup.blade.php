
<div id="editPaymentCatePopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
        <h2 class="text-2xl font-bold text-white">NEW PAYMENT METHOD CATEGORY</h2>
        </div>
        <form id="editPaymentCateForm" action="{{ route('PaymentCateupdate') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="editPMCate_Khname" class="block text-sm font-medium text-gray-900 mb-1">NAME</label>
                <input type="text" id="editPMCate_Khname" name="PMCate_Khname" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('PMCate_Khname')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="editPMCate_Engname" class="block text-sm font-medium text-gray-900 mb-1">ALIAS</label>
                <input type="text" id="editPMCate_Engname" name="PMCate_Engname" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('IPM_alias')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">SAVE</button>
                <button type="button" id="closeeditPaymentCatePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-3 py-2 rounded-md focus:outline-none text-xs">CANCEL</button>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('closeeditPaymentCatePopup').addEventListener('click', function() {
        document.getElementById('editPaymentCatePopup').classList.add('hidden');   
        document.getElementById('editPaymentCateForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('editPaymentCatePopup').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }
</script>

<style>
    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>