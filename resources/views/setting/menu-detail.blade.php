@extends('layouts.setting')

@section('content')

<div class="bg-gray-100">

    <div class="container mx-auto p-6">

        <h1 class="text-center text-3xl font-bold mb-4">MENU DETAIL INFORMATION</h1>

        <div class="relative flex w-full md:w-auto space-x-4">

            <a href="#" id="createMenuDetail" class="bg-primary text-white py-2 px-6 rounded-lg">CREATE</a>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 mt-2">

            @foreach ($menuDetail as $menuID => $value)

            <div class="bg-white p-2 rounded-lg shadow-md flex flex-col">

                <img src="images/shop.jpg" alt="menu Image" class="w-full h-20 object-cover rounded-t-lg">
                <div class="p-2 flex-grow">
                    <h2 class="text-sm text-gray-800 mb-1 font-semibold">{{ $value->first()->Menu->Menu_name_eng}}</h2>
                    <h5 class="text-sm text-gray-900 mb-2"><u>SIZE WITH PRICE LIST</u></h3>
                    @foreach($value as $data)    
                        <div class="mb-2 flex-row">
                            <h3 class="text-sm text-gray-700">{{ $data->Size->Size_name . '            ' . $data->price . '           ' . $data->Currency->Currency_alias}}</h3>
                            <div class="relative group">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300" onclick="openEditMenuDetailPopup({{ $data->pos_menu_detail_id }}, {{ $data->Menu_id ?? 'null' }}, {{ $data->Size_id ?? 'null' }},{{ $data->price ?? 'null'}},{{ $data->Currency_id ?? 'null'}})">
                                    <i class="fas fa-edit fa-sm"></i>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="bg-red-500 text-white py-1 px-3 rounded cursor-pointer transition duration-300" onclick="if(confirm('{{ __('Are you sure you want to delete?') }}')) { window.location.href='menu_detail/destroy/{{$data->pos_menu_detail_id}}'; }">
                                    <i class="fas fa-trash-alt fa-xs"></i>
                                    <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out" >Delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-auto flex justify-between p-2">
                    <div class="relative group">
                        <button class="add-menuDetail-btn bg-green-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300 hover:bg-green-600"
                            data-menu-id="{{ $menuID }}">
                            <i class="fas fa-plus-circle fa-sm"></i> 
                            <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Add</span>
                        </button>
                    </div>
                </div>                
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $getMenuDetail->links() }}
        </div>   
        @include('popups.add-detail-menu-popup')
    </div>
    @include('popups.create-menuDetail-popup')
    @include('popups.edit-menu-detail-popup')
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    const createButton = document.getElementById('createMenuDetail');
    const popupForm = document.getElementById('createMenuDetailPopup');
    createButton.addEventListener('click', () => {

        popupForm.classList.remove('hidden');

    });
    @if($errors->any())

        document.addEventListener('DOMContentLoaded', function() {

            popupForm.classList.remove('hidden');

        });

    @endif
document.addEventListener('DOMContentLoaded', () => {

    const addMenuDetailPopup = document.getElementById('popupAddMenuDetail');
    
    const closeAddMenuDetailPopup = document.getElementById('closeAddMenuDetailPopup');



    document.querySelectorAll('.add-menuDetail-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const menuId = button.getAttribute('data-menu-id');
            const menuIdInput = addMenuDetailPopup.querySelector('input[name="Menu_id"]');
            if (menuIdInput) {
                menuIdInput.value = menuId;
            }
            addMenuDetailPopup.classList.remove('hidden');
        });
    });
    closeAddMenuDetailPopup.addEventListener('click', () => {
        addMenuDetailPopup.classList.add('hidden');
    });
});

function openEditMenuDetailPopup(pos_menu_detail_id, Menu_id, Size_id, price, Currency_id) {
    const editMenuDetailPopup = document.getElementById('EditMenuDetailPopup');
    document.getElementById('editpos_menu_detail_id').value = pos_menu_detail_id;
    document.getElementById('editMenu_id').value = Menu_id;
    document.getElementById('editSize_id').value = Size_id;
    document.getElementById('editprice').value = price;
    document.getElementById('editCurrency_id').value = Currency_id;
    document.getElementById('EditMenuDetailForm').action = `/menu_detail/${pos_menu_detail_id}`;
    editMenuDetailPopup.classList.remove('hidden');
}
</script>
@endsection