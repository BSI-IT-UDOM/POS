

<div id="editPaymentPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

        <h2 class="text-2xl font-bold text-white">EDIT PAYMENT METHOD</h2>

        </div>

        <form id="editPaymentForm" method="POST" action="" class="p-6">
            @csrf
            @method('PATCH')
            <input type="hidden" id="editIPM_id" name="IPM_id">
        

            <div class="mb-4">

                <label for="editIPM_fullname" class="block text-sm font-medium text-gray-900 mb-1">NAME</label>

                <input type="text" id="editIPM_fullname" name="IPM_fullname" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>

            <div class="mb-4">

                <label for="editIPM_alias" class="block text-sm font-medium text-gray-900 mb-1">ALIAS</label>

                <input type="text" id="editIPM_alias" name="IPM_alias" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>
            <input type="hidden" id="editImage" name="image">

            <div class="mb-4">

                <label for="editPMCate_id" class="block text-sm font-medium text-gray-900 mb-1">CATEGORY</label>

                <select id="editPMCate_id" name="PMCate_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('PMCate_id') is-invalid @enderror" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- CATEGORY --</option>

                    <option value="createPaymentCategory">-++ CREATE NEW ++</option>

                    @foreach ($paymentCate as $data)

                        <option value="{{ $data->PMCate_id }}" {{ old('PMCate_id') == $data->PMCate_id ? 'selected' : '' }}>

                            {{ $data->PMCate_Khname . '      ' . $data->PMCate_Engname}}

                        </option>

                    @endforeach

                </select>

                @error('PMCate_id')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="flex justify-end space-x-2">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">SAVE</button>

                <button type="button" id="closeeditPaymentPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-3 py-2 rounded-md focus:outline-none text-xs">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-payment-cate-popup')

</div>
<script src="assets/js/selectSearch.js"></script>
    <script>

    document.getElementById('closeeditPaymentPopup').addEventListener('click', function() {

        document.getElementById('editPaymentPopup').classList.add('hidden');   

        document.getElementById('editPaymentForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('editPaymentPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

    function handleSelect(event) {

        var selectedValue = event.target.value;

        togglePopup('createPaymentCatePopup');

    }

    function togglePopup(popupId) {

        const popup = document.getElementById(popupId);

        popup.classList.remove('hidden');

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