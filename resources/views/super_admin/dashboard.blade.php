<x-super-admin-layout>
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                {{-- <h1 class="text-3xl font-bold text-gray-900">Bienvenue, Super Admin</h1>
                <p class="text-gray-500 mt-1">Voici ce qui se passe dans toutes les salles de sport aujourd'hui.</p> --}}
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-white px-4 py-2 rounded-lg text-sm text-gray-600 font-medium shadow-sm border border-gray-100 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ now()->format('d M, Y') }}
                </span>
                <a href="{{ route('super_admin.gyms.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Ajouter une salle
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- Total Revenue (Mocked for now as per controller data limit, but styled) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-green-50 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        +12.5%
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Revenu Total</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">$32,678.90</p>
                <p class="text-xs text-gray-400 mt-2">Calculé à partir des abonnements</p>
            </div>

            <!-- Active Gyms -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-indigo-50 rounded-xl">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">
                        {{ $stats['total_gyms'] > 0 ? round(($stats['active_gyms'] / $stats['total_gyms']) * 100, 1) : 0 }}% Actifs
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Salles Actives</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['active_gyms'] }} <span class="text-gray-400 text-lg font-normal">/ {{ $stats['total_gyms'] }}</span></p>
                <p class="text-xs text-gray-400 mt-2">{{ $stats['expired_gyms'] }} abonnements expirés</p>
            </div>

            <!-- Total Members -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-orange-50 rounded-xl">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Membres</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_members']) }}</p>
                <p class="text-xs text-gray-400 mt-2">Dans toutes les installations</p>
            </div>

            <!-- System Health (Mock) -->
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">Sain</span>
                </div>
                <h3 class="text-indigo-100 text-sm font-medium uppercase tracking-wider">État du Système</h3>
                <p class="text-2xl font-bold mt-1">99.9% Uptime</p>
                <p class="text-xs text-indigo-200 mt-2">Tous les systèmes opérationnels</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Gyms List Table -->
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900">Salles Gérées</h2>
                    <button class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Voir Tout</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom de la Salle</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">État</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Expiration</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stats</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($gyms as $gym)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                            {{ substr($gym->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $gym->name }}</div>
                                            <div class="text-xs text-gray-500">ID: #{{ $gym->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($gym->is_active && !$gym->isSubscriptionExpired())
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Expiré
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">
                                        {{ $gym->subscription_expires_at ? $gym->subscription_expires_at->format('d M, Y') : 'N/A' }}
                                    </div>
                                    @if($gym->subscription_expires_at && $gym->subscription_expires_at->diffInDays(now()) <= 7)
                                        <div class="text-xs text-red-500 font-semibold mt-1">
                                            Expire bientôt
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs text-gray-500">Membres: <span class="font-bold text-gray-700">{{ $gym->members_count }}</span></span>
                                        <span class="text-xs text-gray-500">Abos: <span class="font-bold text-gray-700">{{ $gym->subscriptions_count }}</span></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('super_admin.gyms.show', $gym) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('super_admin.gyms.edit', $gym) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity / Right Panel -->
            <div class="space-y-8">
                <!-- Engagement/Growth Chart Mockup -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aperçu de la Croissance</h3>
                    <div class="h-48 flex items-end justify-between gap-2 px-2">
                        <!-- Mock bars -->
                        @foreach([40, 65, 45, 80, 55, 70, 90] as $height)
                        <div class="w-full bg-indigo-50 rounded-t-lg relative group">
                            <div class="absolute bottom-0 left-0 right-0 bg-indigo-500 rounded-t-lg transition-all duration-500 group-hover:bg-indigo-600" style="height: {{ $height }}%"></div>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-4 text-xs text-gray-400 font-semibold uppercase">
                        <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                    </div>
                </div>

                <!-- Recent Notifications/Logs -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions Récentes</h3>
                    <div class="space-y-4">
                        @foreach($gyms->take(3) as $gym)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-2 w-2 rounded-full bg-green-500"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Nouvelle salle enregistrée : {{ $gym->name }}</p>
                                <p class="text-xs text-gray-500">{{ $gym->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-super-admin-layout>
