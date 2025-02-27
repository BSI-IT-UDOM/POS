@php
use Illuminate\Support\Facades\Auth;
$navItems = [
    ['route' => 'inventory', 'label' => 'INVENTORY', 'roles' => [1, 2, 3]],
    ['route' => 'supplier', 'label' => 'SUPPLIER', 'roles' => [1, 2, 3]],
    ['route' => 'material', 'label' => 'MATERIAL', 'roles' => [1, 2, 3]],
    ['route' => 'order', 'label' => 'PURCHASE', 'roles' => [1, 2, 3]],
    ['route' => 'pos', 'label' => 'POS', 'roles' => [1, 2, 4]],
    ['route' => 'menu', 'label' => 'MENU', 'roles' => [1, 2, 4]],
    ['route' => 'employee', 'label' => 'EMPLOYEE', 'roles' => [1, 2]],
    ['route' => 'expense', 'label' => 'EXPENSE', 'roles' => [1, 2]],
    ['route' => 'report.index', 'label' => 'REPORT', 'roles' => [1, 2]],
    ['route' => 'profit_lose', 'label' => 'PROFIT / LOSE', 'roles' => [1, 2]],
    ['route' => 'setting', 'label' => 'SETTING', 'roles' => [1, 2]],
];

$user = Auth::user();
$modules = $user->InvRole->modules ?? collect();

$modulesData = $modules->map(function ($module) {
    return $module->only(['status', 'SM_id']); 
});
$modulesWithSysModule = $modules->map(function ($module) {
    return $module->SysModule->only(['SM_label', 'SM_id', 'status']);
});
$modulesDataWithLabel = $modulesData->map(function ($module, $index) use ($modulesWithSysModule) {
    $module['SM_label'] = isset($modulesWithSysModule[$index]['SM_label']) 
        ? strtolower($modulesWithSysModule[$index]['SM_label']) 
        : null; 
    return $module;
});
$activeModules = $modulesDataWithLabel->filter(function ($module) {
    return $module['status'] == 1;
});

$currentRoute = Route::currentRouteName();
@endphp
@vite('resources/css/app.css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="min-h-screen flex flex-col bg-background text-foreground">
    <header class="flex flex-row items-center space-x-4 mt-2 relative">
        <div class="ml-5">
            <div class="ml-0">
                @if($user->invshop && $user->invshop->S_logo)
                    <a href="/home">
                        <img src="{{ asset('storage/' . $user->invshop->S_logo) }}" alt="Shop Logo" class="h-10 w-12 rounded">
                    </a>
                @else
                    <a href="/home">
                        <img src="{{ asset('images/official_logo.png') }}" alt="Default Logo" class="h-10 w-12 rounded">
                    </a>
                @endif
            </div>            
        </div>

        <div class="bg-primary p-3 shadow-md flex items-end justify-end flex-1">
            <div class="space-x-2 items-end justify-end">
                <h1 class="text-sm font-bold text-primary-foreground">{{ $user->sys_name }}</h1>
            </div>
        </div>

        <div class="relative">
            @include('profile.profile')
        </div>
        @include('popups.edit-profile-popup')

        @if (session('success'))
            <div id="success-message" class="fixed top-16 right-4 z-50 opacity-100 transition-opacity duration-500">
                <div class="py-6 px-4 bg-green-500 hover:bg-green-600 text-white rounded-sm shadow-lg">
                    <p>NOTIFICATION</p></br>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="error-message" class="fixed top-16 right-4 z-50 opacity-100 transition-opacity duration-500">
                <div class="py-6 px-4 bg-red-500 hover:bg-red-600 text-white rounded-sm shadow-lg">
                    <p>NOTIFICATION</p></br>
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </header>
    <div class="flex flex-col items-center py-6 -mt-4">
        @if(!request()->is('pos') && !request()->is('table'))
            <button id="menuToggleButton" class="block md:hidden mb-1" onclick="toggleMenu()">
                <i id="menuToggleIcon" class="fas fa-bars text-1xl bg-bsicolor py-1 px-2"></i>
            </button> 

            <div class="w-full flex flex-col items-center">
                @if(!request()->is('home'))
                    <div id="navMenu" class="flex flex-wrap justify-center space-x-2 hidden md:flex">
                        @foreach($navItems as $item)
                        @if(in_array($user->InvRole->R_id, $item['roles']) || $activeModules->contains('SM_label', strtolower($item['label'])))
                            <a href="{{ route($item['route']) }}" class="{{ $currentRoute == $item['route'] ? 'bg-primary text-white' : 'bg-bsicolor text-white' }} rounded-lg px-4 py-2 text-sm mb-2 font-bold">
                                {{ $item['label'] }}
                            </a>
                        @endif
                    @endforeach
                    
                    </div>
                    <div id="menuLine" class="h-1 bg-gray-500 rounded-sm"></div>
                @endif
            </div>
        @endif
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.footer')
</div>

<script>
    function toggleMenu() {
        var navMenu = document.getElementById('navMenu');
        var menuToggleIcon = document.getElementById('menuToggleIcon');
        
        navMenu.classList.toggle('hidden');
        
        if (navMenu.classList.contains('hidden')) {
            menuToggleIcon.classList.remove('fa-times');
            menuToggleIcon.classList.add('fa-bars');
        } else {
            menuToggleIcon.classList.remove('fa-bars');
            menuToggleIcon.classList.add('fa-times');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500);
            }, 5000);
        }

        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                setTimeout(() => errorMessage.remove(), 500);
            }, 5000);
        }
    });
</script>
