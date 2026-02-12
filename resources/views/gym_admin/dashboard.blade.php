<x-gym-layout>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6">
        <!-- Header & Welcome -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
                {{-- <p class="text-gray-500 text-sm mt-1">Bienvenue, {{ Auth::user()->name }}! Voici un résumé de l'activité de votre salle de sport.</p> --}}
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-200 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ now()->translatedFormat('d F Y') }}
                </span>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nouveau membre
                </button>
            </div>
        </div>

        <!-- Subscription Warning -->
        @if(session('subscription_warning'))
            <div x-data="{ show: true }" x-show="show" class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg shadow-sm relative">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-orange-800">Alerte d'abonnement</h3>
                        <div class="mt-2 text-sm leading-5 text-orange-700">
                            <p>L'abonnement de la salle expire dans {{ session('days_until_expiry') }} jours. Veuillez renouveler pour éviter toute interruption de service.</p>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button @click="show = false" class="inline-flex rounded-md p-1.5 text-orange-500 hover:bg-orange-100 focus:outline-none transition ease-in-out duration-150">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Members -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Membres</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMembers }}</p>
                    <div class="flex items-center mt-2 text-xs font-medium text-emerald-600">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        <span>Actuellement actifs</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>

            <!-- Active Members -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Membres Actifs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeMembers }}</p>
                    <div class="flex items-center mt-2 text-xs font-medium text-emerald-600">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Abonnements valides</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>

            <!-- Expiring Soon -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Expire Bientôt</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $expiringSoon }}</p>
                    <div class="flex items-center mt-2 text-xs font-medium text-orange-600">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Dans 7 jours</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenu Total</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ number_format($totalRevenue, 0) }} <span class="text-sm text-gray-400 font-normal">MAD</span></p>
                    <div class="flex items-center mt-2 text-xs font-medium text-gray-400">
                        <span>Abonnements + Ventes</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Middle Section: Visual Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Revenue Cards (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Balance / Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                     <!-- Subscription Revenue Card -->
                    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>

                        <p class="text-indigo-100 font-medium text-sm">Revenus des abonnements</p>
                        <h3 class="text-3xl font-bold mt-2">{{ number_format($subscriptionRevenue, 2) }} <span class="text-sm opacity-70">MAD</span></h3>

                        <div class="mt-8 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-indigo-100">
                                <span class="bg-white/20 px-2 py-0.5 rounded text-xs">Mensuel</span>
                                <span>+15% Croissance</span>
                            </div>
                            <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    <!-- Products Revenue Card -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                        <p class="text-gray-500 font-medium text-sm">Ventes de produits</p>
                        <h3 class="text-3xl font-bold mt-2 text-gray-900">{{ number_format($productRevenue, 2) }} <span class="text-sm text-gray-400 font-normal">MAD</span></h3>

                        <div class="mt-8">
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 text-left">45% de l'objectif mensuel</p>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-gray-900 text-lg">Performance Financière</h3>
                        <select class="text-sm border-gray-200 rounded-lg text-gray-500 focus:ring-indigo-500 focus:border-indigo-500">
                            <option>6 derniers mois</option>
                        </select>
                    </div>
                    <div class="h-80 relative">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Recent Members Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900">Derniers membres inscrits</h3>
                        <a href="{{ route('gym.members.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Membre</th>
                                    <th class="px-6 py-3">CIN</th>
                                    <th class="px-6 py-3">Statut</th>
                                    <th class="px-6 py-3">Plan</th>
                                    <th class="px-6 py-3">Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentMembers as $member)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xs">
                                                {{ substr($member->full_name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $member->full_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->cin }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($member->status == 'Active')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->activeSubscription?->plan?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucun nouveau membre</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Side Stats (Right) -->
            <div class="space-y-6">
                <!-- Member Distribution Chart (Visual Representation) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Répartition des membres</h3>
                    <div class="h-48 relative">
                        <canvas id="membersChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">Total: <span class="font-bold text-gray-900">{{ $totalMembers }}</span> membres</p>
                    </div>
                </div>

                <!-- Upcoming Maintenance -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Maintenance à venir</h3>
                        <a href="{{ route('gym.equipment.index') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">Tout voir</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingMaintenance as $equipment)
                            @foreach($equipment->maintenanceLogs->where('next_maintenance_date', '>=', now()->toDateString())->take(1) as $log)
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0 text-orange-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $equipment->name }}</p>
                                        <p class="text-xs text-gray-500">Prévu le: <span class="font-medium text-orange-600">{{ $log->next_maintenance_date->format('d/m/Y') }}</span></p>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Aucune maintenance prévue.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions / Promo -->
                <div class="bg-indigo-900 rounded-2xl p-6 shadow-sm text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg mb-2">Gestion des plans</h3>
                        <p class="text-indigo-200 text-sm mb-4">Mettez à jour les prix des abonnements et créez de nouvelles offres pour les membres.</p>
                        <a href="{{ route('gym.training-types.index') }}" class="block w-full bg-white text-indigo-900 text-center py-2 rounded-lg font-bold text-sm hover:bg-indigo-50 transition">
                            Gérer les abonnements
                        </a>
                    </div>
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-indigo-800 rounded-full opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-32 h-32 bg-indigo-500 rounded-full opacity-20"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Revenus (MAD)',
                        data: @json($revenueData),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Members Chart
            const ctxMembers = document.getElementById('membersChart').getContext('2d');
            new Chart(ctxMembers, {
                type: 'doughnut',
                data: {
                    labels: ['Actif', 'Inactif', 'Expiré'],
                    datasets: [{
                        data: [{{ $activeMembers }}, {{ $inactiveMembers }}, {{ $expiredMembers }}],
                        backgroundColor: ['#10b981', '#e5e7eb', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
    </script>
</x-gym-layout>
