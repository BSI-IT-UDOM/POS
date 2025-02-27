@extends('layouts.setting')

@section('content')
<div class="flex flex-col">
  <div class="bg-background flex flex-col items-center flex-grow px-4 md:px-0 mt-2">
    <div class="flex flex-col md:flex-row justify-between items-center w-full md:w-4/5">
      <a href="#" id="createPosition" class="bg-green-500 text-white font-bold py-1 px-4 md:py-2 md:px-6 rounded flex items-center text-sm md:text-base">CREATE</a>
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
        <h4 class="text-center font-bold pb-4 text-lg"><u>POSITION INFORMATION</u></h4>
        <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-200">
          <tr>
            <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">ID</th>
            <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">NAME</th>
            <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">ALIAS</th>
            <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">ACTION</th>
          </tr>
        </thead>
        <tbody>
          @foreach($position as $position)
          <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
            <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $loop->iteration }}</td>
            <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $position->position_name }}</td>
            <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $position->position_alias }}</td>
            <td class="py-3 border border-white">
              <button class="relative bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none" onclick="openPositionEditPopup({{ $position->position_id }}, '{{ $position->position_name ?? 'null' }}', '{{ $position->position_alias ?? 'null' }}')">
                <i class="fas fa-edit fa-xs"></i>
              </button>
              <button class="relative bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md focus:outline-none delete-button" data-id="{{ $position->position_id }}">
                <i class="fas fa-trash-alt fa-xs"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('popups.create-position-popup')
  @include('popups.edit-position-popup')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
  document.getElementById('createPosition').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('createPositionPopup').classList.remove('hidden');
  });
  function openPositionEditPopup(position_id, position_name, position_alias) {
    document.getElementById('editposition_id').value = position_id;
    document.getElementById('editposition_name').value = position_name;
    document.getElementById('editposition_alias').value = position_alias;
    document.getElementById('editPositionPopup').classList.remove('hidden');
  }

  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-button").forEach(button => {
      button.addEventListener("click", function() {
        let positionId = this.getAttribute("data-id");

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
            window.location.href = `/position/destroy/${positionId}`;
          }
        });
      });
    });
  });
</script>
@endsection
