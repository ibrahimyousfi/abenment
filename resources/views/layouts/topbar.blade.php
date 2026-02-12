<header class="bg-white border-b border-gray-200 shadow-sm z-10">
    <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Mobile Menu Button -->
        <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Ouvrir le menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Search Bar / Header Actions -->
        <div class="flex-1 flex items-center px-2 lg:ml-6 lg:justify-start">
            @if(isset($header) && $header->isNotEmpty())
                <div class="w-full">
                    {{ $header }}
                </div>
            @else
                <div class="max-w-lg w-full lg:max-w-xs relative">
                    <label for="search" class="sr-only">Rechercher</label>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input id="search" name="search" class="block w-full pr-10 pl-3 py-2 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Rechercher..." type="search">
                </div>
            @endif
        </div>

        <!-- Right Side Icons -->
        <div class="ml-4 flex items-center md:ml-6 space-x-4">

            <!-- Notifications -->
            <button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative">
                <span class="sr-only">Voir les notifications</span>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

            <!-- Profile Dropdown -->
            <div class="ml-3 relative" x-data="{ open: false }">
                <div>
                    <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block ml-3 font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <svg class="hidden md:block h-4 w-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Profil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Paramètres</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem" tabindex="-1" id="user-menu-item-2">Déconnexion</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
