<!-- Popup form -->

<div id="editPromotionDetailPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">EDIT PROMOTION DETAIL</h2>

        </div>

        <form id="editPromotionDetailForm" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            @method('PATCH')

            <input type="hidden" id="editpos_promotion_detail_id" name="pos_promotion_detail_id">

            <input type="hidden" id="editpos_promotion_id" name="pos_promotion_id">

            <div class="mb-4">

                <label for="editpromotion_name" class="block text-sm font-medium text-gray-900 mb-1">PROMOTION NAME</label>

                <input type="text" id="editpromotion_name" name="promotion_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('promotion_name')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="editpos_promotion_type_id" class="block text-sm font-medium text-gray-900 mb-1">PROMOTION TYPE</label>

                <select id="editpos_promotion_type_id" name="pos_promotion_type_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

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

                <label for="editMenu_id" class="block text-sm font-medium text-gray-900 mb-1">MENU NAME</label>

                <select id="editMenu_id" name="Menu_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

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

                <label for="editstart_date" class="block text-sm font-medium text-gray-900 mb-1">START DATE</label>

                <input type="date" id="editstart_date" name="start_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Expiry_date') is-invalid @enderror" value="{{ old('Expiry_date') }}">

                @error('start_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="editend_date" class="block text-sm font-medium text-gray-900 mb-1">END DATE</label>

                <input type="date" id="editend_date" name="end_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Expiry_date') is-invalid @enderror" value="{{ old('Expiry_date') }}">

                @error('end_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="editpromotion_detail_description" class="block text-sm font-medium text-gray-900 mb-1">DESCRIPTION</label>

                <input type="text" id="editpromotion_detail_description" name="promotion_detail_description" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('promotion_percentage')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeeditPromotionDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.edit-promotion-type-popup')

    @include('popups.edit-menu-popup')

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('closeeditPromotionDetailPopup').addEventListener('click', function() {

        document.getElementById('editPromotionDetailPopup').classList.add('hidden');

        document.getElementById('editPromotionDetailForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('editPromotionDetailPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }



    function handleSelect(event) {

        var selectedValue = event.target.value;

        if (selectedValue === 'createPromotionType') {

            togglePopup('editPromotionTypePopup');

        }else if (selectedValue === 'createMenu') {

            togglePopup('editMenuPopup');

        }

    }



    function togglePopup(popupId) {

        const popup = document.getElementById(popupId);

        popup.classList.toggle('hidden');

    }

</script>