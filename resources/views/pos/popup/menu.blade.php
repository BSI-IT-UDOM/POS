<div id="show-item" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-md text-center w-96">
        <img id="popup-image" class="h-24 w-32 m-auto" alt="latte" src="" />
        <h2 class="hidden" id="menu-id"></h2>
        <h2 class="hidden" id="menu-price"></h2>
        <h2 class="hidden" id="menu-category"></h2>
        <h2 class="text-lg font-bold mb-4" id="item-title"></h2>
        <div class="space-y-2">
            <label for="size" class="mr-2">SIZE :</label>
            <select id="size" name="size" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @foreach ($size as $size)
                <option value="{{ $size->Size_id }}" data-name="{{ $size->Size_name }}">
                    {{ $size->Size_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div id="addonField" class="space-y-2 hidden">
            <label for="addon" class="mr-2">SUGAR :</label>
            <select id="addon" name="addon" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @foreach ($addons as $data)
                <option value="{{ $data->Addons_id }}" data-name="{{ $data->Addons_name }}">
                    {{ $data->Addons_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mt-4 space-x-6">
            <button id="close-modal" class="bg-red-500 text-white px-4 py-2 rounded">CLOSE</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">ADD</button>
        </div>
    </div>
</div>
<script>
    let orderCounter = 1;
    let subTotal = 0;

document.querySelectorAll('.item-click').forEach(item => {
    item.addEventListener('click', function () {
        const menuID = this.getAttribute('menu-id')
        const itemName = this.getAttribute('data-item-name');
        const itemImage = this.querySelector('img');
        const menuPrice = this.getAttribute('menu-price');
        const menuCate = this.getAttribute('data-item-id');
        document.getElementById('menu-id').innerText = menuID;
        document.getElementById('menu-category').innerText = menuCate;
        document.getElementById('menu-price').innerText = menuPrice;
        document.getElementById('item-title').innerText = itemName;
        document.getElementById('popup-image').src = itemImage ? itemImage.src : '';
        if (menuCate != 1){
            document.getElementById('addonField').classList.remove('hidden');
        }else{
            document.getElementById('addonField').value = 2;
            document.getElementById('addonField').classList.add('hidden');
        }
        document.getElementById('show-item').classList.remove('hidden');

        document.getElementById('show-item').setAttribute('menu-id', menuID);
        document.getElementById('show-item').setAttribute('menu-price', menuPrice); 
        document.getElementById('show-item').setAttribute('data-item-name', itemName);
        document.getElementById('show-item').setAttribute('data-item-id', menuCate);
    });
});

document.getElementById('close-modal').addEventListener('click', function () {
    document.getElementById('show-item').classList.add('hidden');
});
document.querySelector('#show-item .bg-blue-500').addEventListener('click', function () {
    const menuID= document.getElementById('show-item').getAttribute('menu-id');
    const menuCateID= document.getElementById('show-item').getAttribute('data-item-id');
    const itemName = document.getElementById('show-item').getAttribute('data-item-name');
    const itemPrice = parseFloat(document.getElementById('show-item').getAttribute('menu-price'));
    const selectedAddonId = document.getElementById('addon').value;
    var selectedAddonName;
    if (menuCateID != 1) {
        selectedAddonName = document.querySelector(`#addon option[value="${selectedAddonId}"]`).innerText;
    } else {
        selectedAddonName = "NO SUGAR";
    }
    const selectedSizeId = document.getElementById('size').value;
    const orderTableBody = document.querySelector('tbody');
    let existingRow = Array.from(orderTableBody.querySelectorAll('tr')).find(row => {
        return row.querySelector('td:nth-child(2)').innerText === menuID &&
            row.querySelector('td:nth-child(3)').innerText === itemName &&
            row.querySelector('td:nth-child(5)').innerText === itemPrice &&
            row.querySelector('td:nth-child(6)').innerText === selectedAddonName &&
            row.querySelector('td:nth-child(7)').innerText === selectedSizeId;
    });

    if (existingRow) {
        let quantityCell = existingRow.querySelector('td:nth-child(4) span');
        let currentQuantity = parseInt(quantityCell.innerText);
        quantityCell.innerText = currentQuantity + 1; 
        let priceCell = existingRow.querySelector('td:nth-child(5)');
        priceCell.innerText = (itemPrice * (currentQuantity + 1)).toFixed(2) + ' $'; 
    } else {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="p-2 text-left">${orderCounter++}</td>
            <td class="p-2 text-left hidden">${menuID}</td>
            <td class="p-2 text-left">${itemName}</td>
            <td class="p-2 text-left">
                <div class="flex justify-between items-center">
                    <button class="decrement bg-gray-200 px-2 rounded">-</button>
                    <span>1</span>
                    <button class="increment bg-gray-200 px-2 rounded">+</button>
                </div>
            </td>
            <td class="p-2 text-center">${itemPrice.toFixed(2)} $</td>
            <td class="p-2 text-left">${selectedAddonName}</td> <!-- Display selected addon name -->
            <td class="p-2 text-left hidden">${selectedSizeId}</td> <!-- Display selected Size -->
            <td class="p-2 text-center">
                <button class="bg-gray-200 text-red-600 px-2 py-1 rounded remove-item">
                    <i class="fas fa-trash fa-sm"></i>
                </button>
            </td>
        `;
        orderTableBody.appendChild(newRow);
    }
    subTotal += itemPrice;
    updateSubTotal();
    updateGrandTotal();
    document.getElementById('addon').selectedIndex = 0;
    document.getElementById('size').selectedIndex = 0;
    document.getElementById('show-item').classList.add('hidden');
});


function updateSubTotal() {
    document.querySelector('.text-right .sub-total').innerText = `Sub Total: ${subTotal.toFixed(2)} $`;
}

function updateGrandTotal() {
    const discount = parseFloat(document.getElementById('discount_select').value) || 0;
    const discountAmount = (discount / 100) * subTotal;
    const grandTotal = subTotal - discountAmount;
    document.querySelector('.text-right .grand-total').innerText = `Grand Total: ${grandTotal.toFixed(2)} $`;
}

document.querySelector('tbody').addEventListener('click', function (event) {
    const orderTableBody = document.querySelector('tbody');
    if (event.target.classList.contains('increment') || event.target.classList.contains('decrement')) {
        const row = event.target.closest('tr');
        const quantityCell = row.querySelector('td:nth-child(4) span');
        let currentQuantity = parseInt(quantityCell.innerText);
        const itemPrice = parseFloat(row.querySelector('td:nth-child(5)').innerText.replace(' $', '')) / currentQuantity;
        let priceCell = row.querySelector('td:nth-child(5)');

        if (event.target.classList.contains('increment')) {
            currentQuantity += 1;
        } else if (event.target.classList.contains('decrement') && currentQuantity > 1) {
            currentQuantity -= 1;
        }

        quantityCell.innerText = currentQuantity; 
        priceCell.innerText = (itemPrice * currentQuantity).toFixed(2) + ' $'; 

        subTotal = Array.from(orderTableBody.querySelectorAll('tr')).reduce((total, row) => {
            const rowPrice = parseFloat(row.querySelector('td:nth-child(5)').innerText.replace(' $', ''));
            return total + rowPrice;
        }, 0);
        updateSubTotal();
        updateGrandTotal();
    }
    if (event.target.closest('.remove-item')) {
        const row = event.target.closest('tr');
        const price = parseFloat(row.querySelector('td:nth-child(5)').innerText.replace(' $', ''));

        subTotal -= price; 
        updateSubTotal();
        updateGrandTotal();
        
        row.remove(); 
    }
});
</script>
