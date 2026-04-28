<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center gap-3">

                <!-- LANGUAGE BUTTON -->
                <div class="flex items-center bg-gray-100 rounded-xl p-1">

                    <a href="{{ route('lang.switch','id') }}"
                       class="px-3 py-1.5 text-sm rounded-lg transition
                       {{ app()->getLocale() == 'id'
                            ? 'bg-indigo-600 text-white shadow'
                            : 'text-gray-600 hover:bg-white' }}">
                        🇮🇩 ID
                    </a>

                    <a href="{{ route('lang.switch','en') }}"
                       class="px-3 py-1.5 text-sm rounded-lg transition
                       {{ app()->getLocale() == 'en'
                            ? 'bg-indigo-600 text-white shadow'
                            : 'text-gray-600 hover:bg-white' }}">
                        🇺🇸 EN
                    </a>

                </div>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-xl text-gray-600 bg-white hover:text-gray-800 border border-gray-200 transition">
                            
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">

        <div class="pt-2 pb-3 space-y-1">

            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('user.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <!-- MOBILE LANGUAGE -->
        <div class="px-4 pb-3 flex gap-2">

            <a href="{{ route('lang.switch','id') }}"
               class="flex-1 text-center py-2 rounded-xl text-sm font-medium
               {{ app()->getLocale() == 'id'
                    ? 'bg-indigo-600 text-white'
                    : 'bg-gray-100 text-gray-700' }}">
                🇮🇩 ID
            </a>

            <a href="{{ route('lang.switch','en') }}"
               class="flex-1 text-center py-2 rounded-xl text-sm font-medium
               {{ app()->getLocale() == 'en'
                    ? 'bg-indigo-600 text-white'
                    : 'bg-gray-100 text-gray-700' }}">
                🇺🇸 EN
            </a>

        </div>

        <!-- MOBILE USER -->
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
                        onclick="event.preventDefault();
                        this.closest('form').submit();">

                        {{ __('Log Out') }}

                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>
</nav>