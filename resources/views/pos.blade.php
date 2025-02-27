@extends('layouts.app-nav')
@section('content')
<div class="bg-background p-4 rounded w-full mx-auto">
  <div class="grid sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-6 md:gap-8 lg:gap-12">
    @foreach($table as $tableNumber)
      @php
        $isActive = $checkStatus->contains('pos_table_id', $tableNumber->pos_table_id);
        $tableMenus = $posDetails->filter(function($detail) use ($tableNumber) {
            return $detail->posOrder->pos_table_id == $tableNumber->pos_table_id;
        }); 
      @endphp
      <div class="relative group shadow-md border-4 border-bsicolor rounded-xl bg-gray-200">
        <a href="{{ route('table', $tableNumber) }}">
          <img src="images/table.png" alt="placeholder image" class="w-24 h-16 sm:w-32 sm:h-24 m-auto p-2 sm:p-4" />
          <button class="{{ $isActive ? 'bg-red-500' : 'bg-blue-500' }} text-white p-6 w-full h-24 border-blue-600 border-t-2">
            TABLE {{ $tableNumber->table_name }} </br>
              @foreach($tableMenus as $menu)
                {{$loop->iteration . '. '}} <span class="text-xs">{{ $menu->Menu->Menu_name_eng . '   | ' . $menu->Qty}}</span></br>
              @endforeach
          </button>
        </a>
        <ul class="hidden group-hover:block absolute bg-white text-black p-2 mb-2 rounded-lg shadow-lg bottom-full">
          @foreach($tableMenus as $menu)
            <li class="p-2 hover:bg-gray-200">{{ $menu->Menu->Menu_name_eng . '   | ' . $menu->Qty}}</li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
</div>
@endsection

