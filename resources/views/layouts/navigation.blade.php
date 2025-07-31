<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href=" " class="text-xl font-bold text-orange-500">
                        SpeedBox
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $dashboardRoute = 'dashboard';
                        if (Auth::user()->role == 'admin') {
                            $dashboardRoute = 'admin.dashboard';
                        } elseif (Auth::user()->role == 'driver') {
                            $dashboardRoute = 'driver.dashboard';

                        }
                    @endphp
                    <a href="{{ route($dashboardRoute) }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out
                                            {{ request()->routeIs($dashboardRoute)
    ? 'border-orange-500 text-orange-600 focus:outline-none focus:border-orange-700'
    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300' }}">
                        Dashboard
                    </a>


                    {{-- Link Tambahan Sesuai Role --}}
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.drivers.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold {{ request()->routeIs('admin.drivers.*') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Manajemen
                            Driver</a>
                        <a href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold {{ request()->routeIs('admin.orders.*') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Monitor
                            Pesanan</a>
                        <a href="{{ route('admin.ratings.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold {{ request()->routeIs('admin.ratings.*') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Monitor
                            Rating</a>
                    @elseif(Auth::user()->role == 'customer')
                        <a href="{{ route('orders.history') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold {{ request()->routeIs('orders.history') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">Riwayat
                            Pesanan</a>
                    @elseif(Auth::user()->role == 'driver')
                        <a href="{{ route('driver.history') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold {{ request()->routeIs('driver.history') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            Riwayat Tugas
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div x-data="{ open: false }" class="relative">
                    {{-- Tombol Trigger Dropdown --}}
                    <button @click="open = ! open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-gray-50 hover:text-gray-800 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    {{-- Konten Dropdown --}}
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                        style="display: none;">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                            <a href="{{ route('profile.edit') }}"
                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Profil
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('admin.drivers.index')"
                    :active="request()->routeIs('admin.drivers.*')">Manajemen Driver</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')"
                    :active="request()->routeIs('admin.orders.*')">Monitor Pesanan</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.ratings.index')"
                    :active="request()->routeIs('admin.ratings.*')">Monitor Rating</x-responsive-nav-link>
            @elseif(Auth::user()->role == 'customer')
                <x-responsive-nav-link :href="route('orders.history')"
                    :active="request()->routeIs('orders.history')">Riwayat Pesanan</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>