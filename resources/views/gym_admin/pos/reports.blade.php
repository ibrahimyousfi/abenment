<x-gym-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full gap-4">
            <h2 class="font-bold text-xl text-gray-900 leading-tight whitespace-nowrap">
                {{ __('Rapports de Vente') }}
            </h2>
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('gym.pos.reports') }}" class="flex items-center gap-2">
                    <select name="period" class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Quotidien</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                    </select>
                    <input type="date" name="date" value="{{ $date }}" class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                </form>
                <a href="{{ route('gym.pos.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">
                    Retour POS
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Total Ventes</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_sales'], 2) }} MAD</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Espèces</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-2">{{ number_format($stats['cash_sales'], 2) }} MAD</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Carte Bancaire</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-2">{{ number_format($stats['card_sales'], 2) }} MAD</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Nombre Commandes</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_orders'] }}</p>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-900">Historique des transactions</h3>
                    <button onclick="window.print()" class="text-gray-500 hover:text-gray-700 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Imprimer
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Client</th>
                                <th class="px-6 py-3">Articles</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Paiement</th>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Vendeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">{{ $order->client_name ?? 'Anonyme' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            @foreach($order->items as $item)
                                                <span class="text-xs text-gray-500">
                                                    {{ $item->quantity }}x {{ $item->product->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold">{{ number_format($order->total_amount, 2) }} MAD</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $order->payment_method == 'cash' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($order->payment_method == 'card' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($order->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $order->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4">{{ $order->cashier->name ?? 'Système' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        Aucune transaction trouvée pour cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
