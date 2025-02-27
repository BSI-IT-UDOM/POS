<!-- Popup form -->
<div id="createCurrencyPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-20">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
        <h2 class="text-2xl font-bold text-white">NEW CURRENCY</h2>
        </div>
        <form id="createCurrencyForm" action="{{ route('createCurrency') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf    
        <div class="mb-4">
                <label for="Currency_name" class="block text-sm font-medium text-gray-900 mb-1">NAME</label>
                <input type="text" id="Currency_name" name="Currency_name" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('Currency_name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
            <div class="mb-4">
                <label for="Currency_alias" class="block text-sm font-medium text-gray-900 mb-1">ALIAS</label>
                <input type="text" id="Currency_alias" name="Currency_alias" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('Currency_alias')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">SAVE</button>
                <button type="button" id="closeCreateCurrencyPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-3 py-2 rounded-md focus:outline-none text-xs">CANCEL</button>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('closeCreateCurrencyPopup').addEventListener('click', function() {
        document.getElementById('createCurrencyPopup').classList.add('hidden');
        document.getElementById('createCurrencyForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('createCurrencyPopup').classList.remove('hidden');
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