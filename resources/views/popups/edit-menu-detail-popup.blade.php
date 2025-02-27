<!-- Popup for editing menu detail -->
<div id="EditMenuDetailPopup" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative"> <!-- Added 'relative' for positioning -->
        <h2 class="text-2xl font-bold mb-4">EDIT MENU DETAIL</h2>
        <form id="EditMenuDetailForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <input type="hidden" id="editpos_menu_detail_id" name="pos_menu_detail_id" value=""/>
                <label for="editMenu_id" class="block text-sm font-medium text-gray-900 mb-1">MENU</label>
                <select id="editMenu_id" name="Menu_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Menu_id') is-invalid @enderror">
                    @foreach ($menu as $menu)
                        <option value="{{ $menu->Menu_id }}" selected>
                            {{ $menu->Menu_name_eng }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="editSize_id" class="block text-sm font-medium text-gray-900 mb-1">SIZE</label>
                <select id="editSize_id" name="Size_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IIQ_id') is-invalid @enderror">
                    @foreach ($size as $size)
                        <option value="{{ $size->Size_id }}">
                            {{ $size->Size_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="editprice" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">PRICE</label>
                <input type="numeric" id="editprice" name="price" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            <div class="mb-4">
                <label for="editCurrency_id" class="block text-sm font-medium text-gray-900 mb-1">CURRENCY</label>
                    <select id="editCurrency_id" name="Currency_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Currency_id') is-invalid @enderror">
                        @foreach ($currency as $currency)
                            <option value="{{ $currency->Currency_id }}">
                                {{ $currency->Currency_name }}
                            </option>
                        @endforeach
                    </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">UPDATE</button>
            <button type="button" id="closeEditMenuDetailPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('closeEditMenuDetailPopup').addEventListener('click', function() {
        document.getElementById('EditMenuDetailPopup').classList.add('hidden');   
        document.getElementById('EditMenuDetailForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });
    if ("{{ $errors->any() }}") {
        document.getElementById('EditMenuDetailPopup').classList.remove('hidden');
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



