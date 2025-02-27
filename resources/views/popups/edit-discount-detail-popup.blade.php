<!-- Popup form -->

<div id="editDiscountDetailPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">EDIT DISCOUNT DETAIL</h2>

        </div>

        <form id="editDiscountDetailForm" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            @method('PATCH')

            <input type="hidden" id="editpos_discount_detail_id" name="pos_discount_detail_id">

            <div class="mb-6">

                <label for="editpos_discount_type_id" class="block text-sm font-medium text-gray-900 mb-1">DISCOUNT TYPE</label>

                <select id="editpos_discount_type_id" name="pos_discount_type_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="showDiscountType()" required>

                    <option value="" disabled selected>-- DISCOUNT TYPE NAME --</option>

                    <option value="editDiscountType">++ CREATE NEW ++</option>

                    @foreach ($getDiscount as $discount)

                    <option value="{{ $discount->pos_discount_type_id }}">

                        {{ $discount->discount_type_name }}

                    </option>

                    @endforeach

                </select>

                @error('pos_discount_type_id')

                <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-4">

                <label for="editdiscount_percentage" class="block text-sm font-medium text-gray-900 mb-1">PERCENTAGE</label>

                <input type="text" id="editdiscount_percentage" name="discount_percentage" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('discount_percentage')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="editexpiry_date" class="block text-sm font-medium text-gray-900 mb-1">EXPIRY DATE</label>

                <input type="date" id="editexpiry_date" name="expiry_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">

                @error('expiry_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeeditDiscountDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('closeeditDiscountDetailPopup').addEventListener('click', function() {

        document.getElementById('editDiscountDetailPopup').classList.add('hidden');

        document.getElementById('editDiscountDetailForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('editDiscountDetailPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

</script>