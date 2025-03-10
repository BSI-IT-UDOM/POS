@extends('layouts.setting')

@section('content')
<div class="flex flex-col">
  <div class="bg-background flex flex-col items-center flex-grow px-4 md:px-0 mt-2">
    <div class="flex flex-col md:flex-row justify-between items-center w-full md:w-4/5">
      <a href="#" id="createIncomeCate" class="bg-green-500 text-white font-bold py-1 px-4 md:py-2 md:px-6 rounded flex items-center text-sm md:text-base">CREATE</a>
    </div>
    <div class="w-full md:w-4/5 border-2 border-bsicolor p-2 font-times">
      <div class="overflow-x-auto w-full">
        <h4 class="text-center font-bold pb-4 text-lg"><u>INCOME CATEGORY INFORMATION</u></h4>
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-200">
            <tr class="bg-primary text-primary-foreground text-lg">
              <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">NO.</th>
              <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">NAME IN KHMER</th>
              <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">NAME IN ENGLISH</th>
              <th class="text-center py-2 px-3 md:py-3 md:px-6 border-b text-left">ACTION</th>
            </tr>
          </thead>
          <tbody id="inventoryTableBody">
            @foreach($incomeCate as $category)
            <tr class="{{ $loop->index % 2 === 0 ? 'bg-zinc-200' : 'bg-zinc-300' }} text-base {{ $loop->first ? 'border-t-4' : '' }} text-center border-white">
              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $loop->iteration }}</td>
              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $category->IC_Khname ?? 'null' }}</td>
              <td class="text-center py-2 px-3 md:py-3 md:px-6 border-b">{{ $category->IC_Engname ?? 'null' }}</td>
              <td class="py-3 border border-white">
                <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group "  onclick="EditIncomeCatePopup({{ $category->IC_id }}, '{{ $category->IC_Khname ?? 'null' }}','{{ $category->IC_Engname ?? 'null'}}')">
                  <i class="fas fa-edit fa-xs"></i>
                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">Edit</span>
                </button>
                <button class="relative bg-red-500 hover:bg-red-600 active:bg-red-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group " onclick="deleteIncomeCate({{ $category->IC_id }})">
                  <i class="fas fa-trash-alt fa-xs"></i>
                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out" >Delete</span>
                </button>
                <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group"
                  onclick="toggleActive(this, {{ $category->IC_id }})"
                  onmouseover="setHover(this, true)"
                  onmouseout="setHover(this, false)"
                  style="background-color: {{ $category->status === 'Active' ? '#008000' : '#f00' }}; color: white;">
                  <i class="fas {{ $category->status === 'Active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                  <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                      {{ $category->status === 'Active' ? 'Active' : 'Inactive' }}
                  </span>
              </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('popups.create-income-cate-popup')
  @include('popups.edit-income-cate-popup')
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    document.getElementById('createIncomeCate').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('createIncomeCatePopup').classList.remove('hidden');
    });
    function EditIncomeCatePopup(IC_id, IC_Khname, IC_Engname) {
        document.getElementById('editIC_id').value = IC_id;
        document.getElementById('editIC_Khname').value = IC_Khname;
        document.getElementById('editIC_Engname').value = IC_Engname;
        document.getElementById('editIncomeCateForm').action = `/income_category/${IC_id}`;
        document.getElementById('editIncomeCatePopup').classList.remove('hidden');
    }

    function toggleActive(button, incomeCateId) {
        const icon = button.querySelector('i');
        const currentStatus = icon.classList.contains('fa-toggle-on') ? 'Active' : 'Inactive';
        const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

        fetch(`/income_category/${incomeCateId}/toggle-status`, {
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
    function deleteIncomeCate(IC_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/income_category/destroy/${IC_id}`;
            }
        })
    }
</script>
@endsection
