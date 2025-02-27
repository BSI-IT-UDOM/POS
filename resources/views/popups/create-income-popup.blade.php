<!-- Popup form -->

<div id="createIncomePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">NEW INCOME</h2>

        </div>

        <form id="createIncomeForm" action="{{ route('createincome') }}" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            <div class="mb-4">

                <label for="income_name" class="block text-sm font-medium text-gray-900 mb-1">INCOME NAME</label>

                <input type="text" id="income_name" name="income_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('income_name') is-invalid @enderror" value="{{ old('income_name') }}">

                @error('income_name')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="references_doc" class="block text-sm font-medium text-gray-900 mb-1">DOCUMENT</label>

                <input type="text" id="references_doc" name="references_doc" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 ">

            </div>

            <div class="mb-4">

                <label for="IC_id" class="block text-sm font-medium text-gray-900 mb-1">CATEGORY</label>

                <select id="IC_id" name="IC_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IC_id') is-invalid @enderror" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- CATEGORY --</option>

                    <option value="createIncomeCate">-++ CREATE NEW ++</option>

                    @foreach ($incomeCate as $data)

                        <option value="{{ $data->IC_id }}" {{ old('IC_id') == $data->IC_id ? 'selected' : '' }}>

                            {{ $data->IC_Khname . '      ' . $data->IC_Engname}}

                        </option>

                    @endforeach

                </select>

                @error('IC_id')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="price" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">GRAND TOTAL</label>

                <input type="number" id="price" name="price" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any">

            </div>

            <div class="mb-4">

                <label for="Currency_id" class="block text-sm font-medium text-gray-900 mb-1">CURRENCY</label>

                <select id="Currency_id" name="Currency_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IC_id') is-invalid @enderror" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- CURRENCY --</option>

                    <option value="createCurrency">++ CREATE NEW ++</option>

                    @foreach ($currency as $data)

                        <option value="{{ $data->Currency_id }}" {{ old('Currency_id') == $data->Currency_id ? 'selected' : '' }}>

                            {{ $data->Currency_alias}}

                        </option>

                    @endforeach

                </select>

                @error('IC_id')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="income_date" class="block text-sm font-medium text-gray-900 mb-1">INCOME DATE</label>

                <input type="date" id="income_date" name="income_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('income_date') is-invalid @enderror" value="{{ old('income_date') }}">

                @error('income_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeCreateIncomePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-income-cate-popup')

    @include('popups.create-currency-popup')

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('closeCreateIncomePopup').addEventListener('click', function() {

        document.getElementById('createIncomePopup').classList.add('hidden');   

        document.getElementById('createIncomeForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });

    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('createIncomePopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

    function handleSelect(event) {

var selectedValue = event.target.value;

if (selectedValue === 'createIncomeCate') {

    togglePopup('createIncomeCatePopup');

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