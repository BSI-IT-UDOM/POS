@extends('layouts.app-nav')
@section('content')
<div class="flex flex-col">
  <div class="bg-background flex flex-col items-center flex-grow px-4 md:px-0 mt-2">
    <div class="flex flex-col md:flex-row justify-between items-center w-full md:w-4/5">
      <a href="#" id="createButton" class="bg-primary text-primary-foreground py-1 px-8 rounded-lg md:mb-3 sm:mb-2">CREATE</a>
      <div class="relative flex w-full md:w-auto">
        <form id="searchForm" method="GET" class="w-full md:w-auto flex items-center">
            <input id="searchInput" type="text" name="search" placeholder="Search..." class="border border-input rounded-full py-1 px-4 pl-10 w-full md:w-auto focus:outline-none focus:ring-2 focus:ring-primary" />
            <button type="submit" class="bg-gray-200 rounded-full py-1 px-4 absolute right-0 top-0 mt-1 mr-2 flex items-center justify-center">
                <i class="fas fa-search text-gray-500"></i>
            </button>
        </form>
      </div>
    </div>
    <div class="w-full md:w-4/5 border-2 border-bsicolor p-2 font-times">
      <div class="">
        <h4 class="text-center font-bold pb-4 text-lg"><u>PURCHASE INFORMATION</u></h4>
        <table class="min-w-full bg-white border-collapse text-center overflow-x-auto">
          <thead>
            <tr class="bg-primary text-primary-foreground text-sm sm:text-base lg:text-lg">
              <th class="py-4 px-1 border border-white">NO.</th>
              <th class="py-4 border border-white">PURCHASE NUMBER</th>
              <th class="py-4 border border-white">RECIEPT IMAGE</th>
              <th class="py-4 border border-white">QTY OF MATERIAL</th>
              <th class="py-4 border border-white">TOTAL PRICE</th>
              <th class="py-4 px-4 border border-white">ACTION</th>
            </tr>
          </thead>
          <tbody id="inventoryTableBody">
            @foreach ($order_inf as $data)
            <tr class="{{ $loop->index % 2 === 0 ? 'bg-zinc-200' : 'bg-zinc-300' }} text-base {{ $loop->first ? 'border-t-4' : '' }} text-center border-white order-row" data-order-id="{{ $data->Order_Info_id }}">
              <td class="py-3 px-4 border border-white">{{ $data->Order_Info_id ?? 'null' }}</td>
              <td class="py-3 px-4 border border-white">{{ $data->Order_number ?? 'null' }}</td>
              <td class="flex items-center justify-center py-3 px-4 border border-white"><img src="{{ asset('storage/' . $data->Reciept_image) }}" alt="Shop Logo" class="h-10 w-12 rounded cursor-pointer" onclick="showImageOrder('{{ asset('storage/' . $data->Reciept_image) }}')"></td>
              <td class="relative py-3 px-4 border border-white group">
                {{ $order_inf_counts[$data->Order_Info_id] ?? '0' }}
                <span class="absolute left-0 transform -translate-x-1/2 bottom-full mb-1 text-white text-xs rounded-lg px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-1 pointer-events-none group-hover:pointer-events-auto">
                    <table class="min-w-full bg-white border-collapse text-center border-2 border-gray-500 shadow-2xl">
                        <thead>
                            <tr class="bg-primary text-primary-foreground text-sm sm:text-base lg:text-lg">
                                <th class="py-2 px-8 border-2 border-gray-500">MATERIAL NAME</th>
                                <th class="py-2 px-8 border-2 border-gray-500">NET WEIGHT</th>
                                <th class="py-2 px-2 border-2 border-gray-500">QTY</th>
                                <th class="py-2 px-8 border-2 border-gray-500">PRICE</th>
                                <th class="py-2 px-8 border-2 border-gray-500">SUB TOTAL</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm" id="itemDetails-{{ $data->Order_Info_id }}">
                            <!-- Content will be populated by JavaScript -->
                        </tbody>
                    </table>
                </span>
              </td>
              <td class="py-3 px-4 border border-white">{{ number_format($data->Total_Price, 2) . '     ' .  $data->Currency->Currency_alias ?? 'null' }}</td>
              <td class="py-3 border border-white">
                <button
                class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group"
                onclick="openEditOrderPopup({{ json_encode($data) }})"
            >
                <i class="fas fa-edit fa-xs"></i>
                <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>
            </button>
            <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group delete-order" 
                data-url="{{ url('order/destroy/'.$data->Order_Info_id) }}">
                <i class="fas fa-trash-alt fa-xs"></i>
                <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Delete</span>
            </button>
        
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('popups.create-order-popup')
</div>
@include('popups.updated-order-popup')
<div id="imageOrder" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
  <div class="relative bg-white p-4 rounded-lg">
      <img id="orderImage" src="" alt="Full Image" class="max-w-full max-h-[40rem]">
      <button class="absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white px-4 py-2 rounded" onclick="closeImageOrder()"><i class="fas fa-times"></i></button>
  </div>
</div>
<script>
    function showImageOrder(imageSrc) {
        document.getElementById('orderImage').src = imageSrc;
        document.getElementById('imageOrder').classList.remove('hidden');
    }
    function closeImageOrder() {
        document.getElementById('imageOrder').classList.add('hidden');
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#searchForm').on('submit', function(event) {
      event.preventDefault();
      let searchQuery = $('#searchInput').val();
      $.ajax({
        url: '{{ route("order.search") }}',
        type: 'GET',
        data: { search: searchQuery },
        success: function(response) {
          $('#inventoryTableBody').html(response.html);
        }
      });
    });
    $(document).on('click', '.delete-order', function(event) {
        event.preventDefault();
        let deleteUrl = $(this).data('url');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    });
    document.querySelectorAll('.order-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            let orderId = this.getAttribute('data-order-id');
            let detailsElement = document.getElementById(`itemDetails-${orderId}`);
            detailsElement.innerHTML = '';
            @foreach ($groupedOrders as $orderId => $orders)
                if (orderId == '{{ $orderId }}') {
                    let html = '';
                    @foreach ($orders as $order)
                        html += `
                            <tr class="bg-zinc-200 border border-gray-500 text-sm sm:text-base lg:text-lg">
                                <td class="py-2 px-8 border-2 border-gray-500">{{ $order->material->Material_Engname }}</td>
                                <td class="py-2 px-8 border-2 border-gray-500">{{ $order->Material_Qty  . '   ' .  $order->uom->UOM_abb}}</td>
                                <td class="py-2 px-2 border-2 border-gray-500">{{ $order->Order_Qty }}</td>
                                <td class="py-2 px-2 border-2 border-gray-500">{{ $order->price  . '   ' .  $order->currency->Currency_alias}}</td>
                                <td class="py-2 px-8 border-2 border-gray-500">{{ $order->sub_total . '   ' .  $order->currency->Currency_alias}}</td>
                            </tr>
                        `;
                    @endforeach
                    detailsElement.innerHTML = html;
                }
            @endforeach
        });
        row.addEventListener('mouseleave', function() {
            let orderId = this.getAttribute('data-order-id');
            let detailsElement = document.getElementById(`itemDetails-${orderId}`);
            detailsElement.innerHTML = '';
        });
    });
    const createButton = document.getElementById('createButton');
  const popupForm = document.getElementById('popupOrder');
  const closePopup = document.getElementById('closeOrderPopup');
  createButton.addEventListener('click', function () {
    popupForm.classList.remove('hidden');
  });
  closePopup.addEventListener('click', function () {
    popupForm.classList.add('hidden');
  });
  
  function openEditOrderPopup(order) {
    document.getElementById('editOrderNumber').value = order.Order_number;
    document.getElementById('editTotalPrice').value = order.Total_Price;
    document.getElementById('editOrderDate').value = order.order_date;
    document.getElementById('editSupplier').value = order.Sup_id;
    document.getElementById('editIncVAT').checked = (order.inc_VAT == 1);
    document.getElementById('editCurrency').value = order.currency.Currency_id;

    console.log(document.getElementById('editIncVAT').checked = (order.inc_VAT == 1));


    const form = document.getElementById('editOrderForm');
    form.action = `/order/update/${order.Order_Info_id}`;
    document.getElementById('openEditOrderPopup').classList.remove('hidden');
    let existingItems = @json($existingItems);

    const itemsContainer = document.getElementById('itemsContainer'); 
    itemsContainer.innerHTML = '';
    existingItems = existingItems.filter(item => item.Order_Info_id === order.Order_Info_id);
    existingItems.forEach((item, index) => {
        addItemRowUpdate(index);
        document.getElementById(`QtyMaterial${index}`).value = item.Material_Qty;

        document.getElementById(`inputSelectMaterial${index}`).value = item.material.Material_id;

        document.getElementById(`inputSelectUOM${index}`).value = item.uom.UOM_id;
        console.log(   document.getElementById(`inputSelectUOM${index}`).value = item.uom.UOM_id        );
        console.log( document.getElementById(`inputSelectMaterial${index}`).value = item.material.Material_id);
        
        document.getElementById(`Material_Qty${index}`).value = item.Order_Qty; 
        document.getElementById(`price${index}`).value = item.price;
        document.getElementById(`sub_total${index}`).value = item.sub_total;
        document.getElementById(`expired_Date${index}`).value = item.expiry_date;
    });
}

</script>
@endsection

