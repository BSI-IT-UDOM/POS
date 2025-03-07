

<div id="createPaymentPopup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-20">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

        <h2 class="text-2xl font-bold text-white">NEW PAYMENT METHOD</h2>

        </div>

        <form id="createPaymentForm" action="{{ route('createPayment') }}" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            <div class="mb-4">

                <label for="IPM_fullname" class="block text-sm font-medium text-gray-900 mb-1">NAME</label>

                <input type="text" id="IPM_fullname" name="IPM_fullname" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('IPM_fullname')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="IPM_alias" class="block text-sm font-medium text-gray-900 mb-1">ALIAS</label>

                <input type="text" id="IPM_alias" name="IPM_alias" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('IPM_alias')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="PMCate_id" class="block text-sm font-medium text-gray-900 mb-1">CATEGORY</label>

                <select id="PMCate_id" name="PMCate_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('PMCate_id') is-invalid @enderror" onchange="showCreatePopup()" required>

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

                <button type="button" id="closeCreatePaymentPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-3 py-2 rounded-md focus:outline-none text-xs">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-payment-cate-popup')

</div>
<script src="assets/js/selectSearch.js"></script>
    <script>

    document.getElementById('closeCreatePaymentPopup').addEventListener('click', function() {

        document.getElementById('createPaymentPopup').classList.add('hidden');   

        document.getElementById('createPaymentForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('createPaymentPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }
    function showCreatePopup() {

        var selectedValue = document.getElementById('PMCate_id').value;



        if (selectedValue === 'createPaymentCategory') {

            togglePopup('createPaymentCatePopup');

        } else {

            const popup = document.getElementById('createPaymentCatePopup');

            popup.classList.add('hidden');

        }

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