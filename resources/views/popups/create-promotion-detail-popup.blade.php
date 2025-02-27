<!-- Popup form -->

<div id="createPromotionDetailPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">NEW PROMOTION DETAIL</h2>

        </div>

        <form id="createPromotionDetailForm" action="{{ route('createPromotionDetail') }}"  method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            <div class="mb-4">

                <label for="promotion_name" class="block text-sm font-medium text-gray-900 mb-1">PROMOTION NAME</label>

                <input type="text" id="promotion_name" name="promotion_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('promotion_name')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="pos_promotion_type_id" class="block text-sm font-medium text-gray-900 mb-1">PROMOTION TYPE</label>

                <select id="pos_promotion_type_id" name="pos_promotion_type_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- TYPE NAME --</option>

                    <option value="createPromotionType">++ CREATE NEW ++</option>

                    @foreach ($promotionType as $data)

                    <option value="{{ $data->pos_promotion_type_id }}">

                        {{ $data->promotion_type_name }}

                    </option>

                    @endforeach

                </select>    

            </div>

            <div class="mb-6">

                <label for="Menu_id" class="block text-sm font-medium text-gray-900 mb-1">MENU NAME</label>

                <select id="Menu_id" name="Menu_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- MENU NAME --</option>

                    <option value="createMenu">++ CREATE NEW ++</option>

                    @foreach ($Menu as $data)

                    <option value="{{ $data->Menu_id }}">

                        {{ $data->Menu_name_eng }}

                    </option>

                    @endforeach

                </select>    

            </div>

            <div class="mb-6">

                <label for="start_date" class="block text-sm font-medium text-gray-900 mb-1">START DATE</label>

                <input type="date" id="start_date" name="start_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Expiry_date') is-invalid @enderror" value="{{ old('Expiry_date') }}">

                @error('start_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="end_date" class="block text-sm font-medium text-gray-900 mb-1">END DATE</label>

                <input type="date" id="end_date" name="end_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Expiry_date') is-invalid @enderror" value="{{ old('Expiry_date') }}">

                @error('end_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="promotion_detail_description" class="block text-sm font-medium text-gray-900 mb-1">DESCRIPTION</label>

                <input type="text" id="promotion_detail_description" name="promotion_detail_description" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('promotion_percentage')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeCreatePromotionDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-promotion-type-popup')

    @include('popups.create-menu-popup')

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('closeCreatePromotionDetailPopup').addEventListener('click', function() {

        document.getElementById('createPromotionDetailPopup').classList.add('hidden');

        document.getElementById('createPromotionDetailForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('createPromotionDetailPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

    function handleSelect(event) {

    var selectedValue = event.target.value;

    if (selectedValue === 'createPromotionType') {

        togglePopup('createPromotionTypePopup');

    }else if (selectedValue === 'createMenu') {

        togglePopup('createMenuPopup');

    }

    }



    function togglePopup(popupId) {

        const popup = document.getElementById(popupId);

        popup.classList.toggle('hidden');

    }

</script>