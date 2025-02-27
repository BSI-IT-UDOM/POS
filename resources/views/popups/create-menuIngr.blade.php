<!-- Popup container -->



<div id="popupCreateMenuIngr" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center {{ $errors->any() ? '' : 'hidden' }} z-20">



    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">



        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">



            <h2 class="text-2xl font-bold text-white mb-2">NEW INGREDIENT</h2>



        </div>



        <form id="materialForm" action="{{ route('createIng') }}" method="POST" enctype="multipart/form-data" class="p-6">



            @csrf



            <div class="mb-4">



                <label for="Material_Engname" class="block text-sm font-medium text-gray-900 mb-1">MATERIAL</label>



                <select id="Material_Engname" name="Material_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">



                    <option value="" disabled selected>-- MATERIAL --</option>



                    <option value="createnewING">++ CREATE NEW ++</option>



                    @foreach ($material as $data)



                        <option value="{{ $data->Material_id }}">{{ $data->Material_Engname }}</option> 



                    @endforeach



                </select>



            </div>



            <div class="mb-4">



                <label for="Qty" class="block text-sm font-medium text-gray-900 mb-1">QTY</label>



                <input type="text" id="Qty" name="Qty" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Item_Engname') is-invalid @enderror"  oninput="updateTotalPrice()">



                @error('Qty')



                    <span class="invalid-feedback">{{ $message }}</span>



                @enderror



            </div>







            <div class="mb-4">



                <label for="UOM_abb" class="block text-sm font-medium text-gray-900 mb-1">UNIT OF MEASURE</label>



                <select id="UOM_abb" name="UOM_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">



                    <option value="" disabled selected>-- UOM --</option>

                    <option value="createUOM">++ UOM ++</option>



                    @foreach ($uom as $data)



                        <option value="{{ $data->UOM_id }}">{{ $data->UOM_abb }}</option> 



                    @endforeach



                </select>



            </div>



            <div class="mb-4">



                <label for="price" class="block text-sm font-medium text-gray-900 mb-1">FULL NAME</label>



                <input type="text" id="price" name="IIQ_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>



            </div>



            <div class="text-end">



                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">ADD</button>



                <button type="button" id="closeItemPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>



            </div>



        </form>



    </div>



</div>







<!-- Your HTML content -->






<script src="assets/js/selectSearch.js"></script>
<script>
    document.getElementById('closeItemPopup').addEventListener('click', function() {

        document.getElementById('popupCreateMenuIngr').classList.add('hidden');

        document.getElementById('materialForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

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



