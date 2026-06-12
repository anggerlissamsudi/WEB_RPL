<nav class="bg-white border-b border-gray-200 w-full h-16 flex items-center px-6">
    <div class="w-full flex justify-between items-center">
        
        <div class="flex items-center space-x-3">
            @if(Auth::user()->role === 'admin')
                <span class="text-sm font-black text-gray-700 uppercase tracking-wider">Dashboard Admin Panel</span>
            @else
                <span class="text-sm font-black text-gray-700 uppercase tracking-wider">Dashboard Mahasiswa</span>
            @endif
        </div>

        <div class="flex items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-gray-600 bg-gray-50 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150 cursor-pointer">
                        <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                        
                        <div class="ml-2 text-[10px] text-indigo-600 font-black uppercase bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                            {{ strtoupper(Auth::user()->role) }}
                        </div>
                        
                        <div class="ms-2">
                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

    </div>
</nav>