@vite('resources/css/app.css')
@extends('layouts.app-nav')

@section('content')
  <div class="flex-grow">
    <div class="bg-background flex flex-col items-center mb-4">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full sm:w-4/5 px-4 sm:px-0">
        <div class="relative">
        <button id="createButton" class="bg-primary text-primary-foreground py-1 px-8 rounded-lg md:mb-3 focus:outline-none">
          CREATE
          <i class="fas fa-caret-down ml-2"></i>
        </button>
        <div id="dropdownMenu" class="absolute left-1 mt-2 w-60 bg-gray-300 rounded-md shadow-lg border-2 border-bsicolor hidden z-10">
          <a href="#" id="createExpense" class="block px-4 py-2 text-blue-700 text-lg hover:bg-bsicolor hover:text-blue-800 transition duration-150 ease-in-out border-b-2 border-bsicolor">EXPENSE</a>
          <a href="#" id="createIncome" class="block px-4 py-2 text-blue-700 text-lg hover:bg-bsicolor hover:text-blue-800 transition duration-150 ease-in-out">INCOME</a>
        </div>
      </div>
          <div class="relative w-full sm:w-auto">
            <div class="flex flex-col sm:flex-row items-center rounded-lg px-2 py-1 mb-2">
              <label class="font-semibold sm:mb-0">Start Date:</label>
              <input type="date" class="border border-input p-1 px-4 rounded-lg mr-2 text-sm w-full sm:w-auto sm:mb-0" />
              <span class="mr-4 font-semibold sm:mb-0">End Date:</span>
              <input type="date" class="border border-input p-1 px-4 rounded-lg mr-2 text-sm w-full sm:w-auto sm:mb-0" />
              <button class="bg-yellow-400 text-primary-foreground py-1 px-4 rounded-lg text-sm">SEARCH</button>
            </div>
          </div>
        </div>
      </div>        
      <div class="bg-background text-foreground p-2 flex flex-col items-center justify-center">
        <div class="w-full md:w-4/5">
          <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="flex flex-col w-full md:w-1/3">
              <div class="flex flex-col border-2 border-yellow-400 rounded-lg p-6 text-center bg-gradient-to-r shadow-lg mb-4 h-full">
                <h2 class="text-lg font-semibold text-yellow-700 mb-2">TOTAL SALE AMOUNT</h2>
                <div class="border-t-2 border-yellow-500 my-6"></div>
                <p class="text-3xl font-bold text-yellow-900">{{$countTotalSale ?? 0}}</p>
              </div>
              <div class="flex flex-col border-2 border-yellow-400 rounded-lg p-6 text-center bg-gradient-to-r shadow-lg h-full">
                <h2 class="text-lg font-semibold text-yellow-700 mb-2">TOTAL ORDER AMOUNT</h2>
                <div class="border-t-2 border-yellow-500 my-6"></div>
                <p class="text-3xl font-bold text-yellow-900">{{$countTotalOrder ?? 0}}</p>
              </div>
            </div>
            <div class="flex flex-col w-full md:w-1/3">
              <div class="flex flex-col border-2 border-yellow-400 rounded-lg p-6 text-center bg-gradient-to-r shadow-lg mb-4 h-full">
                <h2 class="text-lg font-semibold text-yellow-700 mb-2">TOTAL INCOME</h2>
                <div class="border-t-2 border-yellow-500 my-6"></div>
                <p class="text-2xl font-bold text-yellow-900">USD: {{ number_format($totalIncome, 2) ?? 00 }}</p>
                <p class="text-2xl font-bold text-yellow-900">RIEL: {{ number_format($totalIncomeReal, 2) ?? 00 }}</p>
              </div>              
              <div class="flex flex-col border-2 border-yellow-400 rounded-lg p-6 text-center bg-gradient-to-r shadow-lg h-full">
                <h2 class="text-lg font-semibold text-yellow-700 mb-2">TOTAL EXPENSE</h2>
                <div class="border-t-2 border-yellow-500 my-6"></div>
                <p class="text-2xl font-bold text-yellow-900">USD: {{ number_format($totalExpense, 2) ?? 00 }}</p>
                <p class="text-2xl font-bold text-yellow-900">RIEL: {{ number_format($totalExpenseReal, 2) ?? 00 }}</p>
              </div>
            </div>
            <div class="flex flex-col w-full md:w-1/3">
              <div class="flex flex-col border-2 border-yellow-400 rounded-lg p-6 text-center bg-gradient-to-r shadow-lg h-full">
                <h2 class="text-lg font-semibold text-yellow-700 mb-2">TOTAL PROFIT</h2>
                <div class="border-t-2 border-yellow-500 my-6"></div>
                <div class="grid grid-cols-3 gap-6 text-center items-center">
                  <div>
                    <p class="text-3xl font-bold text-yellow-700">USD</p>
                    <div class="border-t-2 border-yellow-500 my-6"></div>
                    <p class="text-3xl font-bold text-yellow-900"> {{ number_format($totalIncome - $totalExpense, 2) }}</p>
                  </div>
                  <div class="border-l-2 border-yellow-500 h-24 mx-auto mt-4"></div>
                  <div>
                    <p class="text-3xl font-bold text-yellow-700">RIEL</p>
                    <div class="border-t-2 border-yellow-500 my-6"></div>
                    <p class="text-3xl font-bold text-yellow-900">{{ number_format($totalIncomeReal - $totalExpenseReal, 2) ?? 0 }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>     
    @include('popups.create-income-popup')
  </div> 

  <!-- Include the popup form -->
@include('popups.create-expense-popup')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#searchForm').on('submit', function(event) {
      event.preventDefault();
      let searchQuery = $('#searchInput').val();

      $.ajax({
        url: '{{ route("inventory.search") }}',
        type: 'GET',
        data: { search: searchQuery },
        success: function(response) {
          $('#inventoryTableBody').html(response.html);
        }
      });
    });

    const createButton = document.getElementById('createButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const createExpense = document.getElementById('createExpense');
    const createIncome = document.getElementById('createIncome');

    const popupExpense = document.getElementById('createExpensePopup');
    const popupIncome = document.getElementById('createIncomePopup');

    createButton.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
    });

    createExpense.addEventListener('click', (event) => {
      event.preventDefault();
      dropdownMenu.classList.add('hidden');
      popupExpense.classList.remove('hidden');
    });

    createIncome.addEventListener('click', (event) => {
      event.preventDefault();
      dropdownMenu.classList.add('hidden');
      popupIncome.classList.remove('hidden');
    });

    // Hide dropdown when clicking outside of it
    document.addEventListener('click', (event) => {
      if (!createButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.classList.add('hidden');
      }
    });
  });
</script>

@endsection
