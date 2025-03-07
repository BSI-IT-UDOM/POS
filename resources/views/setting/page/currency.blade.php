<div class="max-w-screen-lg mx-auto p-6 space-y-4 bg-gray-100 border-2 mb-2">
    <div class="flex justify-between items-center">
        <h1 class="items-center text-xl font-bold underline text-gray-700">CURRENCY</h1>
        <h1 class="text-right text-xl font-bold text-gray-700 px-4 py-1 bg-yellow-400 rounded-md">Total = {{ count($currency) }}</h1>
    </div>
    <div id="currencyGrid" class="grid gap-4 w-full p-2" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        @foreach($currency as $data)
        <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col items-center w-full">
            <h3 class="text-xl font-semibold mb-2">{{ $data->Currency_name }}</h3>
            <p class="text-gray-500 text-lg">{{ $data->Currency_alias }}</p>
            <div class="mt-auto  flex justify-end space-x-2">
            <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group "  onclick="openCurrencyEditPopup({{ $data->Currency_id }}, '{{ $data->Currency_name ?? 'null' }}','{{ $data->Currency_alias ?? 'null'}}')">
                  <i class="fas fa-edit fa-xs"></i>
                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>
            </button>
                <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group"
                    onclick="deleteCurrency({{ $data->Currency_id }})">
                    <i class="fas fa-trash-alt fa-xs"></i>
                    <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                        Delete
                    </span>
                </button>
            
                <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group"
                  onclick="toggleActive(this, {{ $data->Currency_id }})"
                  onmouseover="setHover(this, true)"
                  onmouseout="setHover(this, false)"
                  style="background-color: {{ $data->status === 'Active' ? '#008000' : '#f00' }}; color: white;">
                  <i class="fas {{ $data->status === 'Active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                      {{ $data->status === 'Active' ? 'Active' : 'Inactive' }}
                  </span>
              </button>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6 flex justify-end">
        <a href="#" id="createCurrencyButton" class="bg-primary text-primary-foreground py-2 px-4 rounded-md text-xs inline-block"><i class="fas fa-plus mr-2"></i>CREATE</a>
    </div>
</div>
@include('popups.create-currency-popup')
</div>
@include('popups.edit-currency-popup')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
function deleteCurrency(currencyId) {
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
            window.location.href = `/currency/destroy/${currencyId}`;
        }
    });
}
    document.getElementById('createCurrencyButton').addEventListener('click', function() {
        document.getElementById('createCurrencyPopup').classList.remove('hidden');
    });

    function openCurrencyEditPopup(Currency_id, Currency_name, Currency_alias) {
    document.getElementById('editCurrency_id').value = Currency_id;
    document.getElementById('editCurrency_name').value = Currency_name;
    document.getElementById('editCurrency_alias').value = Currency_alias;

    document.getElementById('editCurrencyForm').action = `/currency/${Currency_id}`;
    document.getElementById('editCurrencyPopup').classList.remove('hidden');
}

function toggleActive(button, CurrencyId) {
    const icon = button.querySelector('i');
    const currentStatus = icon.classList.contains('fa-toggle-on') ? 'Active' : 'Inactive';
    const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

    fetch(`/currency/${CurrencyId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (newStatus === 'Active') {
                icon.classList.replace('fa-toggle-off', 'fa-toggle-on');
                button.style.backgroundColor = '#008000'; 
            } else {
                icon.classList.replace('fa-toggle-on', 'fa-toggle-off');
                button.style.backgroundColor = '#f00'; 
            }
        } else {
            alert("Unable to change status.");
        }
    })
    .catch(error => console.error('Error:', error));
}

function setHover(button, isHover) {
    const icon = button.querySelector('i');
    const statusText = button.querySelector('span');
    
    if (icon.classList.contains('fa-toggle-on')) {
        button.style.backgroundColor = isHover ? '#006400' : '#008000';
        statusText.textContent = 'Active';
    } else {
        button.style.backgroundColor = isHover ? '#a11' : '#f00';
        statusText.textContent = 'Inactive';
    }
}
</script>