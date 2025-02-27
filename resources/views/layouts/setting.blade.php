@php
$navItems = [
    ['route' => 'inventory', 'label' => 'INVENTORY', 'roles' => [1, 2, 3]],
    ['route' => 'supplier', 'label' => 'SUPPLIER', 'roles' => [1, 2, 3]],
    ['route' => 'material', 'label' => 'MATERIAL', 'roles' => [1, 2, 3]],
    ['route' => 'order', 'label' => 'PURCHASE', 'roles' => [1, 2, 3]],
    ['route' => 'pos', 'label' => 'POS', 'roles' => [1, 2, 4]],
    ['route' => 'menu', 'label' => 'MENU', 'roles' => [1, 2, 4]],
    ['route' => 'employee', 'label' => 'EMPLOYEE', 'roles' => [1, 2]],
    ['route' => 'expense', 'label' => 'EXPENSE', 'roles' => [1, 2]],
    ['route' => 'report', 'label' => 'REPORT', 'roles' => [1, 2]],
    ['route' => 'profit_lose', 'label' => 'PROFIT / LOSE', 'roles' => [1, 2]],
    ['route' => 'setting', 'label' => 'SETTING', 'roles' => [1, 2]],
];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting - BSI IM-POS SYSTEM</title>
    @vite('resources/css/app.css')
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/logos/Home Town Coffee Logo 3.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        aside {
            transition: transform 0.3s ease;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10;
        }
        .sidebar-active {
            transform: translateX(0);
        }
        .sidebar-inactive {
            transform: translateX(-100%);
        }
        @media(min-width: 1024px) {
            .sidebar-inactive {
                transform: translateX(0);
            }
            .sidebar-active {
                display: none;
            }
            .overlay {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-background text-foreground">
    <header class="flex flex-row items-center space-x-4 mt-2 relattive">
        <div class="ml-5">
            <a href="{{ route('home') }}">
                @if(Auth::check() && Auth::user()->invshop && Auth::user()->invshop->S_logo)
                    <img src="{{ asset('storage/' . Auth::user()->invshop->S_logo) }}" alt="Shop Logo" class="h-10 w-12 rounded">
                @else
                    <img src="{{ asset('images/official_logo.png') }}" alt="Default Logo" class="h-10 w-12 rounded">
                @endif
            </a>
        </div>
        <div class="bg-primary p-3 shadow-md flex items-end justify-end flex-1">
            <h1 class="text-sm font-bold text-primary-foreground">{{ Auth::user()->U_name }}</h1>
        </div>
        <div class="relative">
            @include('profile.profile')
        </div>
        @include('popups.edit-profile-popup')

        <!-- Success and error messages inside the navbar -->

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
    <div class="w-full flex flex-col items-center mt-2">
        @if(request()->is('home'))
        @else
            <div id="navMenu" class="flex flex-wrap justify-center space-x-2 hidden md:flex">
                @foreach($navItems as $item)
                    @if(in_array(Auth::user()->InvRole->R_id, $item['roles']))
                        <a href="{{ $item['route'] }}" class="{{ request()->is($item['route']) ? 'bg-primary text-white text-' : 'bg-bsicolor text-white' }} rounded-lg px-4 py-2 text-sm mb-2 font-bold">
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
            <div id="menuLine" class="h-1 bg-gray-500 rounded-sm"></div>
        @endif
    </div>
    <div class="flex flex-1 h-screen overflow-hidden">
        <!-- Toggle Button for Small Screens -->
        <button class="lg:hidden p-4 text-primary" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Sidebar -->
        <aside id="sidebar" class="text-gray-500 w-64 h-auto bg-gray-200 z-20 lg:z-0 lg:block sidebar-inactive p-4 lg:p-4">
            <nav class="flex flex-col py-4 text-sm">
                <!-- General Settings -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="general-settings">
                        <i class="fas fa-cogs mr-2"></i> GENERAL SETTING
                        <i class="fas fa-chevron-down ml-auto" id="icon-general-settings"></i>
                    </p>
                    <div id="general-settings" class="submenu hidden pl-4">
                        <a href="/uom" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('uom') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-ruler-combined mr-2"></i> UNIT OF MEASURE
                        </a>
                        <a href="/currency" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('currency') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-money-bill-alt mr-2"></i> CURRENCY
                        </a>
                        <a href="/size" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('size') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-ruler mr-2"></i> SIZE
                        </a>
                    </div>
                </div>
                <!-- Company Info -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="company-info">
                        <i class="fas fa-building mr-2"></i> COMPANY INFO
                        <i class="fas fa-chevron-down ml-auto" id="icon-company-info"></i>
                    </p>
                    <div id="company-info" class="submenu hidden pl-4">
                        <a href="/owner" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('owner') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-user-tie mr-2"></i> OWNER
                        </a>
                        <a href="/shop" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('shop') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-store mr-2"></i> SHOP
                        </a>
                        <!--<a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('location') ? 'bg-bsicolor text-white' : '' }}">-->
                        <!--    <i class="fas fa-map-marker-alt mr-2"></i> LOCATION-->
                        <!--</a>-->
                        <a href="/user" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('user') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-user mr-2"></i> USER
                        </a>
                        <a href="/role" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('role') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-user-shield mr-2"></i> ROLE
                        </a>
                        <a href="/position" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('position') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-user-shield mr-2"></i> POSITION
                        </a>
                    </div>
                </div>
                <!-- Menu Info -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="menu-info">
                        <i class="fas fa-box mr-2"></i> MENU INFO
                        <i class="fas fa-chevron-down ml-auto" id="icon-menu-info"></i>
                    </p>
                    <div id="menu-info" class="submenu hidden pl-4">
                        <a href="/menu_group" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('menu_group') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-cube mr-2"></i> GROUP
                        </a>
                        <a href="/menu_category" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('menu_category') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-tags mr-2"></i> CATEGORY
                        </a>
                        <a href="/ingredient" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('ingredient') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-lemon mr-2"></i> INGREDIENT
                        </a>
                        <a href="/add-on" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('add-on') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-plus-circle mr-2"></i> ADD-ON
                        </a>
                        <a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('import_create_menu') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-file-import mr-2"></i> IMPORT / CREATE
                        </a>
                    </div>
                </div>
                <!-- Material Info -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="material-info">
                        <i class="fas fa-box-open mr-2"></i> MATERIAL INFO
                        <i class="fas fa-chevron-down ml-auto" id="icon-material-info"></i>
                    </p>
                    <div id="material-info" class="submenu hidden pl-4">
                        <a href="/material_group" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('material_group') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-box mr-2"></i> GROUP
                        </a>
                        <a href="/material_category" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('material_category') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-cogs mr-2"></i> CATEGORY
                        </a>
                        <a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('create_export') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-file-import mr-2"></i> CREAT / EXPORT
                        </a>
                    </div>
                </div>
                <!-- Profit / Lose Info -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="expense-info">
                        <i class="fas fa-receipt mr-2"></i> PROFIT / LOSE INFO
                        <i class="fas fa-chevron-down ml-auto" id="icon-expense-info"></i>
                    </p>
                    <div id="expense-info" class="submenu hidden pl-4">
                        <a href="/expense_category" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('expense_category') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-tags mr-2"></i> EXPENSE CATEGORY
                        </a>
                        <a href="/income_category" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('income_category') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-tags mr-2"></i> INCOME CATEGORY
                        </a>
                    </div>
                </div>
                <!-- POS -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="pos-info">
                        <i class="fas fa-cash-register mr-2"></i> POS
                        <i class="fas fa-chevron-down ml-auto" id="icon-pos-info"></i>
                    </p>
                    <div id="pos-info" class="submenu hidden pl-4">
                        <a href="/table_setting" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('table') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-table mr-2"></i> TABLE
                        </a>
                        <a href="/menu_detail" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('table') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-utensils mr-2"></i> MENU DETAIL
                        </a>
                        <!-- Discount Section with Nested Dropdown -->
                        <div class="relative">
                            <a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('discount') ? 'bg-bsicolor text-white' : '' }}" data-toggle="discount-info">
                                <i class="fas fa-tags mr-2"></i> DISCOUNT
                                <i class="fas fa-chevron-down ml-auto" id="icon-discount-info"></i>
                            </a>
                            <div id="discount-info" class="submenu hidden pl-4">
                                <a href="/discount_type" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1">
                                    <i class="fas fa-percentage mr-2"></i> DISCOUNT TYPE
                                </a>
                                <a href="/discount_detail" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1">
                                    <i class="fas fa-file-alt mr-2"></i> DISCOUNT DETAIL
                                </a>
                            </div>
                        </div>
                        <!-- Promotion Section with Nested Dropdown -->
                        <div class="relative">
                            <a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('promotion') ? 'bg-bsicolor text-white' : '' }}" data-toggle="promotion-info">
                                <i class="fas fa-bullhorn mr-2"></i> PROMOTION
                                <i class="fas fa-chevron-down ml-auto" id="icon-promotion-info"></i>
                            </a>
                            <div id="promotion-info" class="submenu hidden pl-4">
                                <a href="/promotion_type" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1">
                                    <i class="fas fa-bullhorn mr-2"></i> PROMOTION TYPE
                                </a>
                                <a href="/promotion_detail" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1">
                                    <i class="fas fa-bullhorn mr-2"></i> PROMOTION DETAIL
                                </a>
                            </div>
                        </div>
                        <a href="/payment" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('payment') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-credit-card mr-2"></i> PAYMENT METHOD
                        </a>
                    </div>
                </div>
                <!-- Module Info -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="module-info">
                        <i class="fas fa-cogs mr-2"></i> MODULE INFO
                        <i class="fas fa-chevron-down ml-auto" id="icon-module-info"></i>
                    </p>
                    <div id="module-info" class="submenu hidden pl-4">
                        <a href="/module" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('module') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-cogs mr-2"></i> SYSTEM MODULE
                        </a>
                        <a href="#" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('authentication') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-lock mr-2"></i> AUTHENTICATION
                        </a>
                    </div>
                </div>
                <!-- System Logs -->
                <div class="mb-2">
                    <p class="font-semibold mb-2 flex items-center cursor-pointer px-4 py-2 hover:bg-bsicolor hover:text-white rounded-lg" data-toggle="system-logs">
                        <i class="fas fa-file-alt mr-2"></i> SYSTEM LOGS
                        <i class="fas fa-chevron-down ml-auto" id="icon-system-logs"></i>
                    </p>
                    <div id="system-logs" class="submenu hidden pl-4">
                        <a href="/login_logs" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('login_logs') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-sign-in-alt mr-2"></i> LOGIN LOGS
                        </a>
                        <a href="/operation_logs" class="nav-link flex items-center py-2 px-4 hover:bg-bsicolor hover:text-white rounded-lg my-1 {{ request()->routeIs('operation_logs') ? 'bg-bsicolor text-white' : '' }}">
                            <i class="fas fa-clipboard-list mr-2"></i> OPERATION LOGS
                        </a>
                    </div>
                </div>
            </nav>
        </aside>
        <div class="overlay" id="overlay"></div>
        <main class="flex-1 p-4 overflow-x-auto">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    // Toggle the sidebar visibility
    menuToggle.addEventListener('click', function () {
        sidebar.classList.toggle('sidebar-active');
        sidebar.classList.toggle('sidebar-inactive');
        overlay.style.display = sidebar.classList.contains('sidebar-active') ? 'block' : 'none';
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.add('sidebar-inactive');
        sidebar.classList.remove('sidebar-active');
        overlay.style.display = 'none';
    });

    // Bind click event for submenu toggles
    document.querySelectorAll('[data-toggle]').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const targetId = this.getAttribute('data-toggle');
            const targetSubmenu = document.getElementById(targetId);
            // Check if the clicked toggle is for the "DISCOUNT" and "PROMOTION" menu
            if (targetId !== 'discount-info' && targetId !== 'promotion-info') {
                // Close all other submenus except the "DISCOUNT" and "PROMOTION" submenu
                document.querySelectorAll('.submenu').forEach(function (submenu) {
                    if (submenu !== targetSubmenu && submenu.id !== 'discount-info' && submenu.id !=='promotion-info') {
                        submenu.classList.add('hidden');
                    }
                });
            }
            // Toggle the clicked submenu visibility
            targetSubmenu.classList.toggle('hidden');

        });

    });

});

// Additional script for menu and messages
function toggleMenu() {
    var navMenu = document.getElementById('navMenu');
    var menuToggleIcon = document.getElementById('menuToggleIcon');
    var menuLine = document.getElementById('menuLine');
    navMenu.classList.toggle('hidden');
    if (navMenu.classList.contains('hidden')) {
        menuToggleIcon.classList.remove('fa-times');
        menuToggleIcon.classList.add('fa-bars');
    } else {
        menuToggleIcon.classList.remove('fa-bars');
        menuToggleIcon.classList.add('fa-times');
    }
    setMenuLineWidth();
}


function setMenuLineWidth() {
    var navMenu = document.getElementById('navMenu');
    var menuLine = document.getElementById('menuLine');

    if (window.innerWidth < 768 && navMenu.classList.contains('hidden')) {
        var menuToggleButton = document.getElementById('menuToggleButton');
        menuLine.style.width = menuToggleButton.offsetWidth + 'px';
    } else {
        menuLine.style.width = navMenu.offsetWidth + 'px';
    }
}



window.onload = function() {
    setMenuLineWidth();
}

window.onresize = function() {
    setMenuLineWidth();
}



document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => successMessage.remove(), 500);
        }, 5000); // 5 seconds
    }

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.opacity = '0';
            setTimeout(() => errorMessage.remove(), 500);
        }, 5000); // 5 seconds
    }
});
</script>    
</body>

</html>

