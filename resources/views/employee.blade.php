@extends('layouts.app-nav')

@section('content')



<div class="container mx-auto mt-8 w-4/5">

    <h1 class="text-2xl font-bold mb-6"><U>EMPLOYEE INFORMATION</U></h1>

    

    <div class="mb-4">

        <button id="createEmployee" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">

            CREATE

        </button>

    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach ($employee as $data)

        <div class="bg-white rounded-lg shadow-md p-4">

            <img src="{{ $data->emp_photo ? asset('storage/' . $data->emp_photo) : asset('images/user.png') }}" alt="{{ $data->emp_fullname }}" class="w-full h-48 object-cover rounded-t-lg">

            <div class="mt-4">

                <h2 class="text-lg font-semibold">{{ $data->emp_title . '    ' .$data->emp_fullname }}</h2>

                <p class="text-gray-600">ID: {{ $data->employee_id }}</p>

                <p class="text-gray-600">POSITION: {{ $data->Position->position_name }}</p>

                <p class="text-gray-600">TEL: {{ $data->emp_contact }}</p>

                <p class="text-gray-600">ADDRESS: {{ $data->emp_address }}</p>

            </div>

        </div>

        @endforeach

    </div>

    @include('popups.create-employee')

    @include('popups.edit-employee')

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

    const createButton = document.getElementById('createEmployee');

    const popupForm = document.getElementById('createEmployeePopup');



    createButton.addEventListener('click', () => {

        popupForm.classList.remove('hidden');

    });

    @if($errors->any())

        document.addEventListener('DOMContentLoaded', function() {

            popupForm.classList.remove('hidden');

        });

    @endif

</script>

@endsection

