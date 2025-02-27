@extends('layouts.setting')

@section('content')
<div class="max-w-screen-lg mx-auto p-6 space-y-4 bg-gray-100 border-2 mb-2">
    <div class="container mx-auto p-4">
        <div class="overflow-hidden rounded-lg shadow-lg bg-white">
            <form action="{{ route('module.store') }}" method="POST">
                @csrf
                <table class="min-w-full bg-white border border-zinc-200">
                    <thead>
                        <tr class="bg-zinc-100">
                            <th class="p-4 border-b border-zinc-200 text-left">Module</th>
                            @foreach ($roles as $role)
                                <th class="p-4 border-b border-zinc-200 text-white bg-{{ $role->R_type == 'Admin' ? 'green' : ($role->R_type == 'Owner' ? 'red' : ($role->R_type == 'Inventory' ? 'blue' : 'yellow')) }}-500">{{ $role->R_type }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sysModules as $sysModule)
                            <tr>
                                <td class="p-4 border-b border-zinc-200">{{ $sysModule->SM_name }}</td>
                                @foreach ($roles as $role)
                                    @php
                                        $permission = $sysModule->modules->firstWhere('R_id', $role->R_id);
                                    @endphp
                                    <td class="p-4 border-b border-zinc-200 text-center">
                                        <input type="hidden" name="permissions[{{ $sysModule->SM_id }}][{{ $role->R_id }}][enabled]" value="0">
                                        <input type="checkbox" 
                                               name="permissions[{{ $sysModule->SM_id }}][{{ $role->R_id }}][enabled]" 
                                               value="1" 
                                               class="form-checkbox w-4 h-4 text-teal-500"
                                               {{ $permission && $permission->status == '1' ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-end mt-6 mr-2 mb-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection