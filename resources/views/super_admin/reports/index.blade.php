<x-super-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Rapports & Analyses</h1>
                <p class="text-gray-500 mt-1">Visualisez les performances et les statistiques détaillées.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Revenue Report Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Rapport Financier</h3>
                <p class="text-sm text-gray-500 mb-4">Revenus mensuels, annuels et prévisions de croissance.</p>
                <span class="text-indigo-600 text-sm font-semibold flex items-center">
                    Voir le rapport <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
            </div>

            <!-- Members Report Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Rapport Membres</h3>
                <p class="text-sm text-gray-500 mb-4">Nouveaux inscrits, taux de rétention et désabonnements.</p>
                <span class="text-indigo-600 text-sm font-semibold flex items-center">
                    Voir le rapport <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
            </div>

            <!-- Gym Performance Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Performance des Salles</h3>
                <p class="text-sm text-gray-500 mb-4">Classement des salles les plus actives et les plus rentables.</p>
                <span class="text-indigo-600 text-sm font-semibold flex items-center">
                    Voir le rapport <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
            </div>
        </div>
        
        <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-6 text-center">
            <p class="text-blue-600 font-medium">✨ D'autres rapports avancés seront bientôt disponibles dans cette section.</p>
        </div>
    </div>
</x-super-admin-layout>
