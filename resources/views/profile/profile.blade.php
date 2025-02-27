@php
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

    $dashboardModule = $modulesDataWithLabel->firstWhere('SM_label', 'dashboard');
    $settingModule = $modulesDataWithLabel->firstWhere('SM_label', 'setting');
@endphp
<img src="{{ Auth::user()->U_photo ? asset('storage/' . Auth::user()->U_photo) : asset('images/user.jpg') }}"  
     alt="Admin Profile" 
     class="h-10 w-10 rounded-full cursor-pointer shadow-sm mr-5" 
     id="profileDropdownToggle">
<div id="profileDropdown" 
     class="hidden absolute right-1 mt-2 w-52 bg-white rounded-lg shadow-lg border-2 border-red-500 hover:border-red-600 transition duration-300 z-10">
    <div class="py-1">
        @if ( $dashboardModule['status'] == '1')
            <a href="dashboard" 
               class="block px-4 py-2 text-sm md:text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md transition duration-200">DASHBOARD</a>
        @endif
        <a href="#" 
           class="block px-4 py-2 text-sm md:text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md transition duration-200" 
           id="editProfile">PROFILE</a>
        @if ( $settingModule['status'] == '1')
        <a href="setting" 
           class="block px-4 py-2 text-sm md:text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 border-b border-red-400 rounded-md transition duration-200">SETTING</a>
        @endif
        <a class="block px-4 py-2 text-sm md:text-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition duration-200" 
           href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('LOG OUT') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileDropdownToggle = document.getElementById('profileDropdownToggle');
        const profileDropdown = document.getElementById('profileDropdown');

        profileDropdownToggle.addEventListener('click', function (event) {
            event.stopPropagation(); 
            profileDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function (event) {
            if (!profileDropdown.contains(event.target) && !profileDropdownToggle.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    });
</script>
