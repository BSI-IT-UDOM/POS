<!-- Popup form -->

<div id="createDiscountDetailPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">NEW DISCOUNT DETAIL</h2>

        </div>

        <form id="createDiscountDetailForm" action="{{ route('createDiscountDetail') }}"  method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            <div class="mb-6">

                <label for="pos_discount_type_id" class="block text-sm font-medium text-gray-900 mb-1">DISCOUNT TYPE</label>

                <select id="pos_discount_type_id" name="pos_discount_type_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="showDiscountType()" required>

                    <option value="">-- NAME --</option>

                    <option value="createDiscountType">++ CREATE NEW ++</option>

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

                <label for="discount_percentage" class="block text-sm font-medium text-gray-900 mb-1">PERCENTAGE</label>

                <input type="text" id="discount_percentage" name="discount_percentage" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

                @error('discount_percentage')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="mb-6">

                <label for="expiry_date" class="block text-sm font-medium text-gray-900 mb-1">EXPIRY DATE</label>

                <input type="date" id="expiry_date" name="expiry_date" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Expiry_date') is-invalid @enderror" value="{{ old('Expiry_date') }}">

                @error('expiry_date')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeDiscountDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

</div>
<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('closeDiscountDetailPopup').addEventListener('click', function() {

        document.getElementById('createDiscountDetailPopup').classList.add('hidden');

        document.getElementById('createDiscountDetailForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('createDiscountDetailPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

</script>