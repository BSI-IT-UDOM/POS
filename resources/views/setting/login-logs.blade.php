@extends('layouts.setting')

@section('content')

<div class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Login Information</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Login ID</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">User ID</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Public IP</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">MAC Address</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Login Date/Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userLogs as $data)
                <tr>
                    <td class="py-2 px-4 border-b">{{$data->login_id}}</td>
                    <td class="py-2 px-4 border-b">{{$data->user->U_name ?? 'N/A'}}</td> 
                    <td class="py-2 px-4 border-b">{{$data->public_ip}}</td>
                    <td class="py-2 px-4 border-b">{{$data->mac_add}}</td>
                    <td class="py-2 px-4 border-b">{{$data->login_datetime}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4 flex justify-between items-center">
            <span class="text-sm text-gray-600">Showing 1 to 10 of 50 entries</span>
            <div class="inline-flex">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
                    Prev
                </button>
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

@endsection