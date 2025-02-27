<!-- Popup form -->

<div id="editMenuCatePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">

    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">

        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">

            <h2 class="text-2xl font-bold text-white mb-2">EDIT MENU CATEGORY</h2>

        </div>

        <form id="editMenuCateForm" method="POST" enctype="multipart/form-data" class="p-6">

            @csrf

            @method('PATCH')

            <input type="hidden" id="editMenu_Cate_id" name="Menu_Cate_id">

            <div class="mb-4">

                <label for="editCate_Khname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN KHMER</label>

                <input type="text" id="editCate_Khname" name="Cate_Khname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>

            <div class="mb-4">

                <label for="editCate_Engname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN ENGLISH</label>

                <input type="text" id="editCate_Engname" name="Cate_Engname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>

            <div class="mb-6">

                <label for="editMenuGr_id" class="block text-sm font-medium text-gray-900 mb-1">GROUP</label>

                <select id="editMenuGr_id" name="MenuGr_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>

                    <option value="">-- GROUP --</option>

                    <option value="createMenuGr">++ CREATE NEW ++</option>

                    @foreach ($group as $data)

                    <option value="{{ $data->MenuGr_id }}">

                        {{ $data->MenuGr_Engname }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="text-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>

                <button type="button" id="closeeditMenuCatePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>

            </div>

        </form>

    </div>

    @include('popups.create-menuGroup-popup')

  </div>
  <script src="assets/js/selectSearch.js"></script>
  <script>

    document.getElementById('closeeditMenuCatePopup').addEventListener('click', function() {

        document.getElementById('editMenuCatePopup').classList.add('hidden');

        document.getElementById('editMenuCateForm').reset();    

        const invalidFields = document.querySelectorAll('.is-invalid');

        invalidFields.forEach(field => field.classList.remove('is-invalid'));

        const errorMessages = document.querySelectorAll('.invalid-feedback');

        errorMessages.forEach(message => message.textContent = '');

    });



    // Display the popup if validation errors are present

    if ("{{ $errors->any() }}") {

        document.getElementById('editMenuCatePopup').classList.remove('hidden');

        const firstInvalid = document.querySelector('.is-invalid');

        if (firstInvalid) {

            firstInvalid.focus({ preventScroll: true });

        }

    }

    function handleSelect(event) {

        var selectedValue = event.target.value;

        togglePopup('createMenuGrPopup');

    }

    function togglePopup(popupId) {

        const popup = document.getElementById(popupId);

        popup.classList.remove('hidden');

    }

</script>