<x-gym-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rapport Financier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Date Filter -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                <form method="GET" action="{{ route('gym.reports.financial') }}" class="flex flex-wrap items-end gap-4">
                    <div class="w-full md:w-auto">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Du</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="w-full md:w-auto">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Au</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors h-[38px]">
                        Générer le rapport
                    </button>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Revenue -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Revenus Totaux</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($revenue, 2) }} MAD</div>
                </div>

                <!-- Expenses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Dépenses Totales</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($expenses, 2) }} MAD</div>
                </div>

                <!-- Net Profit -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 {{ $netProfit >= 0 ? 'border-indigo-500' : 'border-orange-500' }}">
                    <div class="text-sm font-medium text-gray-500 uppercase">Bénéfice Net</div>
                    <div class="mt-2 text-3xl font-bold {{ $netProfit >= 0 ? 'text-indigo-600' : 'text-orange-600' }}">
                        {{ number_format($netProfit, 2) }} MAD
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Trend Chart -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
                    <h3 class="font-bold text-gray-900 mb-4">Évolution Financière (6 derniers mois)</h3>
                    <div class="h-80 relative">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Revenue Breakdown -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Répartition des Revenus</h3>
                    @if(count($revenueByType) > 0)
                        <div class="h-64 relative">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-10">Aucune donnée disponible.</p>
                    @endif
                </div>

                <!-- Expenses Breakdown -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Répartition des Dépenses</h3>
                    @if(count($expensesByCategory) > 0)
                        <div class="h-64 relative">
                            <canvas id="expensesChart"></canvas>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-10">Aucune donnée disponible.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'bar',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: 'Revenus',
                            data: @json($trendRevenue),
                            backgroundColor: '#10b981',
                            borderRadius: 4
                        },
                        {
                            label: 'Dépenses',
                            data: @json($trendExpenses),
                            backgroundColor: '#ef4444',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Revenue Chart
            @if(count($revenueByType) > 0)
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($revenueByType->toArray())),
                    datasets: [{
                        data: @json(array_values($revenueByType->toArray())),
                        backgroundColor: ['#4f46e5', '#8b5cf6', '#ec4899', '#f43f5e'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
            @endif

            // Expenses Chart
            @if(count($expensesByCategory) > 0)
            const ctxExpenses = document.getElementById('expensesChart').getContext('2d');
            new Chart(ctxExpenses, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($expensesByCategory->toArray())),
                    datasets: [{
                        data: @json(array_values($expensesByCategory->toArray())),
                        backgroundColor: ['#f59e0b', '#ef4444', '#3b82f6', '#10b981', '#6b7280', '#8b5cf6'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
            @endif
        });
    </script>
</x-gym-layout>
