<!-- Popup form -->
<div id="createMenuCatePopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">NEW MENU CATEGORY</h2>
        </div>
        <form id="menuCateForm" action="{{ route('createMenuCate') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="Cate_Khname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN KHMER</label>
                <input type="text" id="Cate_Khname" name="Cate_Khname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('Cate_Khname')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="Cate_Engname" class="block text-sm font-medium text-gray-900 mb-1">NAME IN ENGLISH</label>
                <input type="text" id="Cate_Engname" name="Cate_Engname" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('Cate_Engname')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-6">
                <label for="MenuGr_id" class="block text-sm font-medium text-gray-900 mb-1">GROUP</label>
                <select id="MenuGr_id" name="MenuGr_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="showMenuGr()" required>
                    <option value="">-- GROUP --</option>
                    <option value="createMenuGr">++ CREATE NEW ++</option>
                    @foreach ($group as $data)
                    <option value="{{ $data->MenuGr_id }}">
                        {{ $data->MenuGr_Engname }}
                    </option>
                    @endforeach
                </select>
                @error('MenuGr_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closeCreateMenuCatePopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>
        </form>
    </div>
    @include('popups.create-menuGroup-popup')
  </div>
  <script>
    document.getElementById('closeCreateMenuCatePopup').addEventListener('click', function() {
        document.getElementById('createMenuCatePopup').classList.add('hidden');
        document.getElementById('menuCateForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('createMenuCatePopup').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }
    function showMenuGr() {
        var selectedValue = document.getElementById('MenuGr_id').value;
        
        if (selectedValue === 'createMenuGr') {
            togglePopup('createMenuGrPopup');
        } else {
            const popup = document.getElementById('createMenuGrPopup');
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