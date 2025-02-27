<div id="openEditOrderPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-20">
    <div class="bg-white rounded-lg shadow-lg max-w-5xl w-full mx-4 max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-green-500 to-green-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">EDIT PURCHASE</h2>
        </div>
        <form id="editOrderForm" class="p-6" method="POST" action="{{ route('order.update', ':id') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Purchase Information -->
            <div class="flex flex-wrap -mx-2 mb-4">
                <h3 class="w-full text-lg font-bold text-gray-800 mb-2">PURCHASE INFORMATION</h3>
                <div class="w-full h-0.5 bg-green-500 rounded-sm mb-4"></div>

                <!-- Order Number (readonly) -->
                <div class="w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="editOrderNumber" class="block text-sm font-medium text-gray-900 mb-1">PURCHASE NUMBER</label>
                    <input type="text" id="editOrderNumber" name="Order_number" value="" class="text-center border rounded-md px-3 py-1 w-full focus:ring-green-500" readonly>
                </div>

                <!-- Receipt Image -->
                <div class="w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="editReceiptImage" class="block text-sm font-medium text-gray-900 mb-1">RECEIPT IMAGE</label>
                    <input type="file" id="editReceiptImage" name="Receipt_image" class="border rounded-md px-3 py-1 w-full focus:ring-green-500">
                </div>

                <!-- Total Price -->
                <div class="w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="editTotalPrice" class="block text-sm font-medium text-gray-900 mb-1">TOTAL PRICE</label>
                    <input type="number" id="editTotalPrice" name="Total_Price" value="" class="text-center border rounded-md px-3 py-1 w-full focus:ring-green-500" step="any">
                </div>

                <!-- Supplier -->
                <div class="w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="editSupplier" class="block text-sm font-medium text-gray-900 mb-1">SUPPLIER</label>
                    <select id="editSupplier" name="Sup_id" class="text-center border rounded-md px-3 py-2 w-full focus:ring-green-500" required>
                        <option value="" disabled selected>-- SUPPLIER --</option>
                        @foreach ($Supplier as $data)
                            <option value="{{ $data->Sup_id }}">{{ $data->Sup_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- VAT Checkbox -->
                <div class="w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="editIncVAT" class="block text-sm font-medium text-gray-900 mb-1">VAT</label>
                    <input type="checkbox" id="editIncVAT" name="inc_VAT" class="h-6 w-6 focus:ring-green-500">
                </div>


                <!-- Purchase Date -->
                <div class="w-full sm:w-1/5 px-2 mb-4">
                    <label for="editOrderDate" class="block text-sm font-medium text-gray-900 mb-1">PURCHASE DATE</label>
                    <input type="date" id="editOrderDate" name="order_date" value="" class="text-center border rounded-md px-3 py-1 w-full focus:ring-green-500">
                </div>
                <div class="w-full sm:w-1/5 px-2 mb-4">
                    <label for="editCurrency" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">CURRENCY</label>
                    <select id="editCurrency" name="Currency_id" class="text-center text-sm sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                        <option value="" disabled selected>-- CURRENCY --</option>
                        @foreach ($currency as $data)
                        <option value="{{ $data->Currency_id }}">
                            {{ $data->Currency_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
  

            <!-- Material List -->
            <h3 class="w-full text-lg font-bold text-gray-800 mb-2">MATERIAL LIST</h3>
            <div class="w-full h-0.5 bg-green-500 rounded-sm mb-4"></div>
            <div id="editItemsContainer" class="flex flex-wrap -mx-2 mb-4">
                <!-- Material rows will be dynamically added here -->
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:ring-green-500 mr-2">SAVE</button>
                <button type="button" id="closeEditOrderPopup" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:ring-gray-500">CANCEL</button>
            </div>
        </form>
    </div>
</div>

<script>

document.getElementById('closeEditOrderPopup').addEventListener('click', function () {
    document.getElementById('openEditOrderPopup').classList.add('hidden');
    location.reload(); 
});



    function addItemRowUpdate(index) {
    var today = new Date().toISOString().split('T')[0];
    var itemRow = `
        <div class="item-row w-full flex" id="itemRow${index}">
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-6">
                <label for="inputSelectMaterial${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">MATERIAL</label>
                <select disabled selected id="inputSelectMaterial${index}" name="inputSelectMaterial[]" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                    <option value="" disabled selected>-- MATERIAL --</option>
                    @foreach ($materials as $data)
                        <option value="{{ $data->Material_id }}">
                            {{ $data->Material_Engname . ' ' . $data->Material_Khname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="QtyMaterial${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">NET WEIGHT</label>
                <input type="number" id="QtyMaterial${index}" name="QtyMaterial[]" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="inputSelectUOM${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">UOM</label>
                <select id="inputSelectUOM${index}" name="inputSelectUOM[]" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>-- UOM --</option>
                    @foreach ($uom as $data)
                        <option value="{{ $data->UOM_id }}">
                            {{ $data->UOM_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="Material_Qty${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">QTY</label>
                <input type="number" id="Material_Qty${index}" name="Material_Qty[]" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="updateTotalPriceForData()" required>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="price${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">PRICE</label>
                <input type="number" id="price${index}" name="price[]" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any" oninput="updateTotalPriceForData()" required>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="sub_total${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">SUB TOTAL</label>
                <input type="number" id="sub_total${index}" name="sub_total[]" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any" readonly>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="expired_Date${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">EXPIRY DATE</label>
                <input type="date" id="expired_Date${index}" name="expired_Date[]" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="${today}">
            </div>
        </div>
    `;

    document.getElementById('editItemsContainer').insertAdjacentHTML('beforeend', itemRow);
}



function updateTotalPriceForData() {
    var totalPriceField = document.getElementById('editTotalPrice'); // Corrected to use editTotalPrice
    var itemsContainer = document.getElementById('editItemsContainer'); // Corrected container ID
    var priceInputs = itemsContainer.querySelectorAll('input[id^="price"]');
    var qtyInputs = itemsContainer.querySelectorAll('input[id^="Material_Qty"]');
    var subTotalInputs = itemsContainer.querySelectorAll('input[id^="sub_total"]');
    var totalPrice = 0;

    priceInputs.forEach(function(input, index) {
        var price = parseFloat(input.value) || 0;
        var qty = parseFloat(qtyInputs[index].value) || 0;
        var subTotal = price * qty;
        subTotalInputs[index].value = subTotal.toFixed(2);
        totalPrice += subTotal;
    });

    totalPriceField.value = totalPrice.toFixed(2);
}

</script>
