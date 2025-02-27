<!-- Popup form -->
<div id="createExpensePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">NEW EXPENSE</h2>
        </div>
        <form id="createExpenseForm" action="{{ route('createExpense') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="Exp_name" class="block text-sm font-medium text-gray-900 mb-1">EXPENSE NAME</label>
                <input type="text" id="Exp_name" name="Exp_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Exp_name') is-invalid @enderror" value="{{ old('Exp_name') }}">
                @error('Exp_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="references_doc" class="block text-sm font-medium text-gray-900 mb-1">DOCUMENT</label>
                <input type="text" id="references_doc" name="references_doc" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 ">
            </div>
            <div class="mb-4">
                <label for="IEC_id" class="block text-sm font-medium text-gray-900 mb-1">CATEGORY</label>
                <select id="IEC_id" name="IEC_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IEC_id') is-invalid @enderror" onchange="handleSelect(event)" required>
                    <option value="" disabled selected>-- CATEGORY --</option>
                    <option value="createExpenseCate">-++ CREATE NEW ++</option>
                    @foreach ($expenseCat as $data)
                        <option value="{{ $data->IEC_id }}" {{ old('IEC_id') == $data->IEC_id ? 'selected' : '' }}>
                            {{ $data->IEC_Engname . '      ' . $data->IEC_Khname}}
                        </option>
                    @endforeach
                </select>
                @error('IEC_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">PRICE</label>
                <input type="number" id="price" name="price" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any">
            </div>
            <div class="mb-4">
                <label for="Currency_id" class="block text-sm font-medium text-gray-900 mb-1">CURRENCY</label>
                <select id="Currency_id" name="Currency_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IEC_id') is-invalid @enderror" onchange="handleSelect(event)" required>
                    <option value="" disabled selected>-- CURRENCY --</option>
                    <option value="createCurrency">++ CREATE NEW ++</option>
                    @foreach ($currency as $data)
                        <option value="{{ $data->Currency_id }}" {{ old('Currency_id') == $data->Currency_id ? 'selected' : '' }}>
                            {{ $data->Currency_alias}}
                        </option>
                    @endforeach
                </select>
                @error('IEC_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-6">
                <label for="Exp_date" class="block text-sm font-medium text-gray-900 mb-1">EXPENSE DATE</label>
                <input type="date" id="Exp_date" name="Exp_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Exp_date') is-invalid @enderror" value="{{ old('Exp_date') }}">
                @error('Exp_date')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closeCreateExpensePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>
        </form>
    </div>
    @include('popups.create-expense-cat-popup')

    @include('popups.create-currency-popup')
  </div>
  <script src="assets/js/selectSearch.js"></script>
  <script>
    document.getElementById('closeCreateExpensePopup').addEventListener('click', function() {
        document.getElementById('createExpensePopup').classList.add('hidden');   
        document.getElementById('createExpenseForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('createExpensePopup').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }
    function handleSelect(event) {
var selectedValue = event.target.value;
if (selectedValue === 'createExpenseCate') {
    togglePopup('createExpenseCatePopup');
}else if (selectedValue === 'createCurrency') {
    togglePopup('createCurrencyPopup');
}

}

function togglePopup(popupId) {

    const popup = document.getElementById(popupId);

    popup.classList.toggle('hidden');

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