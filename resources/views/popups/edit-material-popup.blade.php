<div id="editMaterialPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">

    <div class="bg-white rounded-lg w-1/2">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">EDIT ITEM</h2>

        </div>

        <form id="editMaterialForm" action="" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            @method('PATCH')

            <input type="hidden" id="editMaterial_id" name="Item_id" value="">

            <div class="mb-4">

                <label for="editMaterial_Khname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN KHMER</label>

                <input type="text" id="editMaterial_Khname" name="Material_Khname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>

            <div class="mb-4">

                <label for="editMaterial_Engname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN ENGLISH</label>

                <input type="text" id="editMaterial_Engname" name="Material_Engname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>

            <div class="mb-6">

                <label for="editMaterial_Cate_Khname" class="block text-sm font-medium text-gray-900 mb-1">CATEGORY</label>

                <select id="editMaterial_Cate_Khname" name="Material_Cate_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

                    <option value="" disabled selected>-- CATEGORY --</option>

                    <option value="createMaterialCate">++ CREATE NEW ++</option>

                    @foreach ($categories as $data)

                    <option value="{{ $data->Material_Cate_id }}" data-uom-name="{{ $data->Material_Cate_Khname }}">

                        {{ $data->Material_Cate_Khname . '      ' . $data->Material_Cate_Engname}}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-4">

                <label for="editimage" class="block text-sm font-medium text-gray-900 mb-1">IMAGE</label>

                <div>

                    <button type="button" class="select-logo" onclick="document.getElementById('editimage').click()">BROWSE</button>

                    <input type="file" id="editimage" name="image" style="display:none">

                </div>

                <img id="imagePreview" src="" alt="Image Preview" class="h-20 w-24 rounded hidden mt-2">

              </div>

            <div class="flex justify-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none mr-2">UPDATE</button>

                <button type="button" id="cancelMaterialEdit" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-material-cat-popup')

</div>


<script src="assets/js/selectSearch.js"></script>
<script>

    document.getElementById('cancelMaterialEdit').addEventListener('click', function() {

        // Hide the popup

        document.getElementById('editMaterialPopup').classList.add('hidden');

        // Clear the form data

        document.getElementById('editmaterialForm').reset();    

        // Clear file input

        document.getElementById('image').value = '';

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('editMaterialPopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

    function handleSelect(event) {

        var selectedValue = event.target.value;

        if (selectedValue === 'createMaterialCate'){

            togglePopup('createMaterialCatePopup');

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