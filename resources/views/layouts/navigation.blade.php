<nav x-data="{ open: false }" class="bg-white border-r border-gray-200 w-full md:w-64 min-h-screen flex-shrink-0 hidden md:flex md:flex-col shadow-sm z-20 transition-all duration-300">
    <!-- Logo Section -->
    <div class="h-16 flex items-center justify-center border-b border-gray-100">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group px-4">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-md shadow-indigo-200 transition group-hover:scale-110">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">GYM<span class="text-indigo-600">SAAS</span></span>
        </a>
    </div>

    <!-- User Info (Sidebar Top) -->
    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">Admin</p>
            </div>
        </div>
    </div>

    <!-- Sidebar Links -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">MENU PRINCIPAL</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Tableau de bord
        </a>

        <a href="{{ route('members.index') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('members.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('members.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Membres
        </a>

        <a href="{{ route('training-types.index') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors group {{ request()->routeIs('training-types.*') || request()->routeIs('plans.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('training-types.*') || request()->routeIs('plans.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Abonnements et Plans
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">GESTION</p>

        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Planning
        </a>

        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Présence
        </a>

        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Rapports Financiers
        </a>

        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Paramètres
        </a>
    </div>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
</nav>
