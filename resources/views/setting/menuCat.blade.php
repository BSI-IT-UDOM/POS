@extends('layouts.setting')

@section('content')

<div class="flex flex-col">

  <div class="bg-background flex flex-col items-center flex-grow px-4 md:px-0 mt-2">

    <div class="flex flex-col md:flex-row justify-between items-center w-full md:w-4/5">

      <a href="#" id="createMenuCate" class="bg-green-500 text-white font-bold py-1 px-4 md:py-2 md:px-6 rounded flex items-center text-sm md:text-base">CREATE</a>

      <div class="relative flex w-full md:w-auto">

        <form id="searchForm" method="GET" class="w-full md:w-auto flex items-center">

          <input id="searchInput" type="text" placeholder="Search..." class="border border-input rounded-full py-1 px-4 pl-10 w-full md:w-auto focus:outline-none focus:ring-2 focus:ring-primary"  /> 

          <button type="submit" class="bg-gray-200 rounded-full py-1 px-4 absolute right-0 top-0 mt-1 mr-2 flex items-center justify-center">
            <i class="fas fa-search text-gray-500"></i>
          </button>

        </form>

      </div>

    </div>

    <div class="w-full md:w-4/5 border-2 border-bsicolor p-2 font-times">

      <div class="overflow-x-auto w-full">

        <h4 class="text-center font-bold pb-4 text-lg"><u>MENU CATEGORY INFORMATION</u></h4>

        <table class="min-w-full bg-white shadow-md rounded-lg">

          <thead class="bg-gray-200">

            <tr class="bg-primary text-primary-foreground text-lg">

              <th class="py-4 px-4 border border-white">NO.</th>

              <th class="py-4 px-4 border border-white">NAME IN KHMER</th>

              <th class="py-4 px-4 border border-white">NAME IN ENGLISH</th>

              <th class="py-4 px-4 border border-white">GROUP</th>

              <th class="py-4 px-4 border border-white">ACTION</th>

            </tr>

          </thead>

          <tbody id="inventoryTableBody">

            @foreach($menu_category as $category)

            <tr class="{{ $loop->index % 2 === 0 ? 'bg-zinc-200' : 'bg-zinc-300' }} text-base {{ $loop->first ? 'border-t-4' : '' }} text-center border-white">

              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $loop->iteration }}</td>

              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $category->Cate_Khname ?? 'null' }}</td>

              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $category->Cate_Engname ?? 'null' }}</td>

              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $category->MenuGr_id ?? 'null' }}</td>

              <td class="py-3 border border-white">

                <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group " onclick="openeditMenuCatePopup({{ $category->Menu_Cate_id }}, '{{ $category->Cate_Khname ?? 'null' }}','{{ $category->Cate_Engname ?? 'null'}}')">

                  <i class="fas fa-edit fa-xs"></i>

                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>

                </button>

                <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group" onclick="confirmDelete({{ $category->Menu_Cate_id }})">
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

  @include('popups.create-menu-cat-popup')

  @include('popups.edit-menu-cat-popup')

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>

    document.getElementById('createMenuCate').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('createMenuCatePopup').classList.remove('hidden');
    });

    function openeditMenuCatePopup(Menu_Cate_id, Cate_Khname, Cate_Engname) {
        document.getElementById('editMenu_Cate_id').value = Menu_Cate_id;
        document.getElementById('editCate_Khname').value = Cate_Khname;
        document.getElementById('editCate_Engname').value = Cate_Engname;
        document.getElementById('editMenuGr_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const uomName = selectedOption.getAttribute('data-uom-name');
        });
        document.getElementById('editMenuCateForm').action = `/menu_category/${Menu_Cate_id}`;
        document.getElementById('editMenuCatePopup').classList.remove('hidden');
    }

    function confirmDelete(Menu_Cate_id) {
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
                window.location.href = `/menu_category/destroy/${Menu_Cate_id}`;
            }
        });
    }
</script>

@endsection
