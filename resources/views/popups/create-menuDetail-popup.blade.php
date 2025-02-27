<div id="createMenuDetailPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">MAP MENU DETAIL</h2>
        </div>
        <form id="createMenuDetailForm" action="{{ route('mapMenuDetail') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                    <label for="menu_detail_description" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">DESCRIPTION</label>
                    <input type="text" id="menu_detail_description" name="menu_detail_description" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any">
            </div>
            <div class="mb-4">
                <label for="Menu_id" class="block text-sm font-medium text-gray-900 mb-1">MENU</label>
                <select id="Menu_id" name="Menu_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Menu_id') is-invalid @enderror">
                    <option value="" disabled selected>-- MENU --</option>
                    @foreach ($menu as $menu)
                        <option value="{{ $menu->Menu_id }}" {{ old('Menu_id') == $menu->Menu_id ? 'selected' : '' }}>
                            {{ $menu->Menu_name_eng }}
                        </option>
                    @endforeach
                </select>
                @error('Menu_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="Size_id" class="block text-sm font-medium text-gray-900 mb-1">SIZE</label>
                <select id="Size_id" name="Size_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IIQ_id') is-invalid @enderror">
                    <option value="" disabled selected>-- SIZE --</option>
                    @foreach ($size as $size)
                        <option value="{{ $size->Size_id }}" {{ old('Size_id') == $size->Size_id ? 'selected' : '' }}>
                            {{ $size->Size_name }}
                        </option>
                    @endforeach
                </select>
                @error('Size_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">PRICE</label>
                <input type="numeric" id="price" name="price" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                </div>
            <div class="mb-4">
                <label for="Currency_id" class="block text-sm font-medium text-gray-900 mb-1">CURRENCY</label>
                    <select id="Currency_id" name="Currency_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IIQ_id') is-invalid @enderror">
                        <option value="" disabled selected>-- CURRENCY --</option>
                        @foreach ($currency as $currency)
                            <option value="{{ $currency->Currency_id }}" {{ old('Currency_id') == $currency->Currency_id ? 'selected' : '' }}>
                                {{ $currency->Currency_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('Currency_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closecreateMenuDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>
        </form>
    </div>
</div>
<script src="assets/js/selectSearch.js"></script>
<script>
    document.getElementById('closecreateMenuDetailPopup').addEventListener('click', function() {
        document.getElementById('createMenuDetailPopup').classList.add('hidden');   
        document.getElementById('createMenuDetailForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });
    if ("{{ $errors->any() }}") {
        document.getElementById('createMenuDetailPopup').classList.remove('hidden');
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



