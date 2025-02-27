@php
use App\Models\OrderInfor;
$date = date('Y-m-d');
$i = 1;
$latestOrder = OrderInfor::whereDate('order_date', '=', $date)
                        ->orderBy('order_date', 'desc')
                        ->orderBy('Order_number', 'desc')
                        ->first();
if ($latestOrder) {
    $lastOrderNumber = $latestOrder->Order_number;
    $parts = explode('_', $lastOrderNumber);
    $sequence = (int) end($parts) + 1;
} else {
    $sequence = 1;
}
$orderNumber = 'Order_' . str_replace('/', '-', $date) . '_' . str_pad($sequence, 3, '0', STR_PAD_LEFT);

@endphp 

@extends('layouts.app-nav')
@section('content')
<div class="flex flex-col w-full max-h-[500px] m-auto">
    <div class="flex flex-col md:flex-row w-full -mt-5">
        <div class="flex-1 justify-center -mt-2 w-8/12">
            <div class="p-4 w-full">
                <!-- Menu Buttons (Drink/Food) -->
                <div class="flex space-x-2 mb-2 justify-center top-0">
                    @foreach($menuGr as $menuGroup)
                        <button id="{{ $menuGroup->MenuGr_Engname }}" class="bg-zinc-300 text-black px-4 py-1 rounded group-button">{{ $menuGroup->MenuGr_Engname }}</button>
                    @endforeach
                </div>
                <!-- Drink Categories -->
                <div id="drink-categories" class="flex space-x-2 mb-6 justify-center">
                    @foreach($menuCat as $category)
                        @if($category->MenuGr_id == 1)
                            <button class="bg-zinc-300 text-black px-4 py-1 rounded category-button" 
                                    data-category="{{ $category->Menu_Cate_id }}" 
                                    data-menu-cate-id="{{ $category->Menu_Cate_id }}">
                                {{ $category->Cate_Engname }}
                            </button>
                        @endif
                    @endforeach
                </div>
                <!-- Food Categories -->
                <div id="food-categories" class="hidden flex space-x-2 mb-2 justify-center">
                    @foreach($menuCat as $category)
                        @if($category->MenuGr_id == 2)
                            <button class="bg-zinc-300 text-black px-4 py-1 rounded category-button" 
                                    data-category="{{ $category->Menu_Cate_id }}">
                                {{ $category->Cate_Engname }}
                            </button>
                        @endif
                    @endforeach
                </div>
                <!-- Item Grid -->
                <div id="items" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-2 text-sm flex-1 max-h-[600px] overflow-y-auto">
                    @foreach($categories as $type => $menuItems)
                        @foreach($menuItems as $data)
                            <div class="drink-item hidden h-60" data-category="{{ $type }}">
                                <div class="border-2 border-bsicolor rounded-md p-2 text-center item-click flex flex-col justify-between h-full" menu-id="{{$data->Menu_id }}" data-item-name="{{ $data->Menu_name_eng }}" data-item-id="{{ $data->Menu_Cate_id }}" menu-price="{{ $data->MenuDetail->price ?? 0}}">
                                    @if($data->image)
                                        <img src="{{ asset('storage/' . $data->image) }}" alt="Menu Image" class="h-auto w-full rounded">
                                    @else
                                        <span class="text-gray-500"></span>
                                    @endif
                                    <p>{{ $data->Menu_name_eng }}</p>
                                    <h5>{{ $data->MenuDetail->price ?? 0}} $</h5>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <!-- Food Items -->
                    <div class="food-item hidden" data-category="{{ $type }}">
                            <div class="border-2 border-bsicolor rounded-md p-2 text-center item-click flex flex-col justify-between h-full" menu-id="{{$data->Menu_id }}" data-item-name="{{ $data->Menu_name_eng }}"  data-item-id="{{ $data->Menu_Cate_id }}" menu-price="{{ $data->MenuDetail->price ?? 0}}">
                                @if($data->image)
                                    <img src="{{ asset('storage/' . $data->image) }}" alt="Menu Image" class="h-10 w-12 rounded">
                                @else
                                    <span class="text-gray-500"></span>
                                @endif
                                <p>{{ $data->Menu_name_eng }}</p>
                                <p>{{ $data->MenuDetail->price ?? 0}} $</p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="border-2 border-bsicolor p-4 flex-1 md:w-2/5 flex flex-col h-[590px] justify-between w-4">
            <table class="w-full border-collapse">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="p-2 text-left">NO.</th>
                        <th class="p-2 text-left">MENU NAME</th>
                        <th class="p-2 text-center">QTY</th>
                        <th class="p-2 px-4 text-center">PRICE</th>
                        <th class="p-2 text-center">SUGAR</th>
                        <th class="p-2 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($tableStatus == 'ORDERED')
                        @foreach ($orderDetail as $ordered)
                        <tr>
                            <td class="p-2 text-left">{{$loop->iteration}}</td>
                            <td class="p-2 text-left hidden">{{ $ordered->Menu_id }}</td>
                            <td class="p-2 text-left">{{ $ordered->Menu->Menu_name_eng }}</td>
                            <td class="p-2 text-left">
                                <div class="flex justify-between items-center">
                                    <button class="decrement bg-gray-200 px-2 rounded">-</button>
                                    <span>{{ $ordered->Qty }}</span>
                                    <button class="increment bg-gray-200 px-2 rounded">+</button>
                                </div>
                            </td>
                            <td class="p-2 text-center">{{ $ordered->price }} $</td>
                            <td class="p-2 text-left">{{ $ordered->Addons->Addons_name }}</td> <!-- Display selected addon name -->
                            <td class="p-2 text-center">
                                <button class="bg-gray-200 text-red-600 px-2 py-1 rounded remove-item" disabled>
                                <i class="fas fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="text-right border-gray-500 border-t-2">
                @if ($tableStatus == 'ORDERED')
                    @foreach ($order as $data)
                        <p class="mt-4 sub-total">Sub Total: {{$data->sub_total ?? 0.00}} $</p>
                        <div class="mt-2">
                            <label for="discount_select" class="mr-2">Discount Type:</label>
                            <select id="discount_select" class="border rounded p-1 mr-2">
                                <option id="$data->pos_discount_detail_id" value="{{ $data->discount_amount }}" selected>{{ $data->DiscountDetail->Discount->discount_type_name }}</option>
                            </select>
                            <label for="discount">Discount (%): </label>
                            <input type="number" id="discount" class="border rounded p-1 w-16" value="{{ $data->discount_amount }}" disabled>
                        </div>
                        <p class="mt-2 grand-total" total-price="{{$data->grand_total ?? 0.00}} ">Grand Total: {{$data->grand_total ?? 0.00}} $</p> 
                    @endforeach
                @else
                    <p class="mt-4 sub-total">Sub Total: 0.00 $</p>
                    <div class="mt-2">
                        <label for="discount_select" class="mr-2">Discount Type:</label>
                        <select id="discount_select" class="border rounded p-1 mr-2">
                            <option value="" disabled selected>Select value</option>
                            @foreach ($discountDetail as $data)
                                <option id="{{ $data->pos_discount_detail_id }}" value="{{ $data->discount_percentage }}">{{ $data->Discount->discount_type_name }}</option>
                            @endforeach
                        </select>
                        <label for="discount">Discount (%): </label>
                        <input type="number" id="discount" class="border rounded p-1 w-16" value="0" disabled>
                    </div>
                    <p class="mt-2 grand-total">Grand Total: 0.00 $</p>
                @endif
            </div>
            @if ($tableStatus !== 'ORDERED')
                <form id="order-form" action="{{ route('order.submit') }}" method="POST">
                    @csrf
                    <div class="flex justify-between mt-24">        
                        <input type="hidden" name="order_data[0][Addons_id]" id="Addons_id" value="" />
                        <input type="hidden" name="pos_discount_detail_id" id="pos_discount_detail_id" />
                        <input type="hidden" name="discount_amount" id="discount_amount" />
                        <input type="hidden" name="grand_total" id="grand-total-input" />
                        <input type="hidden" name="sub_total" id="sub-total-input" />
                        <input type="hidden" name="pos_table_id" value="{{ $pos_table_id }}">                  
                        <input type="hidden" name="order_date" id="order_date"value="{{ $date  }}"  />
                        <input type="hidden" name="order_number" id="order_number" value="{{ $orderNumber }}" />
                        <input type="hidden" name="order_data" id="order-data" />
                        <button type="submit" id="order-button" class="bg-bsicolor text-white px-4 py-1 rounded ml-auto" disabled>
                            ORDER
                        </button>
                        </div>
                    </div>
                </form>
            @else
                @foreach ($order as $data)
                    <button type="submit" id="openCheckBill" class="bg-bsicolor text-white px-4 py-1 rounded ml-auto" order-id="{{ $data->pos_order_id }}">CHECK BILL</button>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('pos.popup.menu')
@include('pos.popup.check-bill')

@if ($tableStatus !== 'ORDERED')
<script>
    document.querySelectorAll('.item-click').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('order-button').disabled = false;
        });
    });
    document.getElementById('DRINK').addEventListener('click', function() {
        document.getElementById('drink-categories').classList.remove('hidden');
        document.getElementById('food-categories').classList.add('hidden');
        document.querySelectorAll('.food-item').forEach(item => item.classList.add('hidden'));
        document.querySelectorAll('.drink-item').forEach(item => item.classList.add('hidden'));
    });

    document.getElementById('FOOD').addEventListener('click', function() {
        document.getElementById('food-categories').classList.remove('hidden');
        document.getElementById('drink-categories').classList.add('hidden');
        document.querySelectorAll('.drink-item').forEach(item => item.classList.add('hidden'));
        document.querySelectorAll('.food-item').forEach(item => item.classList.add('hidden'));
        document.querySelectorAll('.food-item[data-category="soup"]').forEach(item => item.classList.remove('hidden'));
    });
    document.querySelectorAll('.group-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.group-button').forEach(btn => {
                btn.classList.remove('active'); 
            });
            this.classList.add('active');
        });
    })
    document.querySelectorAll('.category-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.category-button').forEach(btn => {
                btn.classList.remove('active'); 
            });
            this.classList.add('active');

            const category = this.getAttribute('data-category');
            const menuCateId = this.getAttribute('data-menu-cate-id');
            if (this.closest('#drink-categories')) {
                document.querySelectorAll('.drink-item').forEach(item => {
                    item.classList.toggle('hidden', item.getAttribute('data-category') !== category);
                });
            } else {
                document.querySelectorAll('.food-item').forEach(item => {
                    item.classList.toggle('hidden', item.getAttribute('data-category') !== category);
                });
            }
        });
    })
    document.getElementById('discount_select').addEventListener('change', function() {
        const discountInput = document.getElementById('discount');
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.text !== 'CUSTOM') {
            discountInput.disabled = true;
            discountInput.value = selectedOption.value
        } else {
            discountInput.disabled = false;
            discountInput.select();
            discountInput.focus();
        }
        calculateGrandTotal();
    });

    document.getElementById('discount').addEventListener('input', function() {
        calculateGrandTotal();
    });
    function calculateGrandTotal() {
        const discountValue = parseFloat(document.getElementById('discount_select').value) || 0;
        const discountInputValue = parseFloat(document.getElementById('discount').value) || 0;
        const subTotalElement = document.querySelector('.sub-total');
        const grandTotalElement = document.querySelector('.grand-total');
        const subTotalText = subTotalElement.textContent.replace('Sub Total: ', '').replace(' $', '');
        const subTotal = parseFloat(subTotalText) || 0;
        const discountAmount = discountInputValue > 0 ? (subTotal * (discountInputValue / 100)) : (subTotal * (discountValue / 100));
        const grandTotal = subTotal - discountAmount;
        grandTotalElement.textContent = `Grand Total: ${grandTotal.toFixed(2)} $`;
    }

    document.getElementById('order-form').addEventListener('submit', function(e) {
        const discountSelect = document.getElementById('discount_select');
        const selectedOption = discountSelect.options[discountSelect.selectedIndex];
        const discountInput = document.getElementById('discount');

        document.getElementById('pos_discount_detail_id').value = selectedOption.id;
        document.getElementById('discount_amount').value = discountInput.value

        const grandTotalText = document.querySelector('.grand-total').textContent.replace('Grand Total: ', '').replace(' $', '');
        const grandTotal = parseFloat(grandTotalText) || 0;
        document.getElementById('grand-total-input').value = grandTotal;

        const subTotalText = document.querySelector('.sub-total').textContent.replace('Sub Total: ', '').replace(' $', '');
        const subTotal = parseFloat(subTotalText) || 0;
        document.getElementById('sub-total-input').value = subTotal;
});


document.getElementById('order-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const selectedAddonId = document.getElementById('addon').value;
    document.getElementById('Addons_id').value = selectedAddonId;
    const discountSelect = document.getElementById('discount_select');
    const selectedOption = discountSelect.options[discountSelect.selectedIndex];
    const discountInput = document.getElementById('discount');
    if (selectedOption.id == 0) {
        selectedOption.id = 1
    }
    document.getElementById('pos_discount_detail_id').value = selectedOption.id;
    document.getElementById('discount_amount').value = discountInput.value;
    const orderItems = [];
    document.querySelectorAll('tbody tr').forEach(row => {
        const menuID = parseInt(row.querySelector('td:nth-child(2)').innerText) || 0;
        const quantity = parseInt(row.querySelector('td:nth-child(4) span').innerText) || 0;
        const itemPrice = parseFloat(row.querySelector('td:nth-child(5)').innerText.replace(' $', '')) || 0;
        const addon = parseInt(selectedAddonId) || 0;
        const size = parseInt(row.querySelector('td:nth-child(7)').innerText) || 0;
        const itemData = {
            Menu_id: menuID,
            Qty: quantity,
            price: itemPrice,
            Addons_id: addon,
            Size_id: size
        };
        orderItems.push(itemData);
    });
    document.getElementById('order-data').value = JSON.stringify(orderItems);
    this.submit();
});
</script>
@else
    <script>
        const popupForm = document.getElementById('checkBillPopup');
        document.getElementById('openCheckBill').addEventListener('click', function() {
            popupForm.classList.remove('hidden');
        });
    </script>
@endif


<style>
    @media (max-width: 1100px) {
        .flex-col {
            flex-direction: column !important;
        }
        .border-2.border-bsicolor {
            width: 100%;
            margin-left: 0px !important;
        }
        .flex-1 {
            width: 100%;
        }
        .border-t-2 {
            margin-top: 50px;
            margin-bottom: 30px;
        }
    }
    .category-button.active {
        background-color: #007BFF;
        color: white;
    }
    .group-button.active {
        background-color: #007BFF;
        color: white;
    }
</style>
@endsection
