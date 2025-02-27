<div id="checkBillPopup" class="fixed inset-0 bg-gray-600 bg-opacity-70 flex justify-center items-center hidden z-20">
    <form id="checkBill" action="{{ route('order.checkbill') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="bg-white p-6 rounded-lg shadow-lg w-[500px]">
            <div class="flex space-x-4 mb-6">
                @foreach ($payment as $paymethod)
                    <div class="text-center p-4 rounded-lg flex-1 cursor-pointer">
                        @if($paymethod->image)
                            <img name="IPM_id" id="{{$paymethod->IPM_id}}" src="{{ asset('storage/' . $paymethod->image) }}" alt="{{$paymethod->IPM_alias}}" class="bg-bsicolor mx-auto p-1 transition-all duration-100 ease-in-out">
                        @else
                            <span class="text-gray-500"></span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="flex space-x-2 mb-4">
                @foreach ($currency as $currency)
                    <div class="text-center p-4 rounded-lg flex-1 cursor-pointer">
                        <h3 name="currency-id" id="{{$currency->Currency_id}}" class="text-lg font-bold mb-4 bg-gray-200">{{$currency->Currency_alias}}</h3>
                    </div>
                @endforeach
            </div>
            <!-- <div class="space-y-4">
                <h2 name="order-id" class="text-xl font-bold" id="order-id"></h2>
            </div> -->
            <div class="space-y-4">
                @if ($tableStatus == 'ORDERED')
                    @foreach ($order as $data)
                    <div class="flex justify-center border-2 border-gray-500 p-2">
                        <h3 class="text-xl font-bold">{{ $data->grand_total }} USD</h3>
                    </div>
                    <div class="flex justify-center border-2 border-gray-500 p-2">
                        <h3 class="text-xl font-bold">{{number_format($data->grand_total * 4100, 2) }} KHR</h3>
                    </div>
                    @endforeach
                @endif
            </div>
            <input type="hidden" name="pos_order_id" id="pos_order_id">
            <input type="hidden" name="IPM_id" id="IPM_id">
            <input type="hidden" name="Currency_id" id="Currency_id">
            <div class="flex justify-end mt-6">
                <button id="closeCheckBill" type="button" class="bg-gray-400 text-white py-2 px-4 rounded-sm mr-2">
                    CANCEL
                </button>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-sm">
                    SUBMIT
                </button>
            </div>  
        </div>
    </form>
</div>

<script>
    const images = document.querySelectorAll('img');
    images.forEach((img) => {
        img.addEventListener('click', function () {
            images.forEach((el) => el.classList.remove('border-4', 'border-blue-500'));
            img.classList.add('border-4', 'border-blue-500');
            document.getElementById('IPM_id').value = this.getAttribute('id');
            console.log(document.getElementById('IPM_id').value);
        });
    });
    const currency = document.querySelectorAll('h3');
    currency.forEach((h3) => {
        h3.addEventListener('click', function () {
            currency.forEach((el) => el.classList.remove('border-4', 'border-blue-500'));
            h3.classList.add('border-4', 'border-blue-500');
            document.getElementById('Currency_id').value = this.getAttribute('id');
        });
    });
    document.getElementById('closeCheckBill').addEventListener('click', function() {
        document.getElementById('checkBill').reset();    
        document.getElementById('checkBillPopup').classList.add('hidden');
    });

    document.getElementById('openCheckBill').addEventListener('click', function () {
        const orderID = this.getAttribute('order-id');
        document.getElementById('pos_order_id').value = orderID;
    });
</script>
