@extends('layouts.setting')

@section('content')

<div class="bg-gray-100 p-6">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4"><u>OPERATION LOGS</u></h2>
        <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Log ID</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Table Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Operation Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Column Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Old Value</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Old Value</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">New Value</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">New Value</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Log Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                      @foreach ($operationLog as $data) 
                        <tr>
                            <td class="py-2 px-4">{{$data->Log_id}}</td>
                            <td class="py-2 px-4">{{$data->table_name}}</td>
                            <td class="py-2 px-4">{{$data->operation_name}}</td>
                            <td class="py-2 px-4">{{$data->column_name}}</td>
                            <td class="py-2 px-4">{{$data->old_value_str}}</td>
                            <td class="py-2 px-4">{{$data->old_value_num}}</td>
                            <td class="py-2 px-4">{{$data->new_value_str}}</td>
                            <td class="py-2 px-4">{{$data->new_value_num}}</td>
                            <td class="py-2 px-4">{{$data->log_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
        <div class="mt-4">
          {{ $operationLog->links() }}
        </div>
    </div>
</div>

@endsection