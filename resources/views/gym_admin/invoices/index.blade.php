<x-gym-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Factures</h2>
                <p class="text-sm text-gray-500">Gérez vos factures et paiements</p>
            </div>
            <a href="{{ route('gym.invoices.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Créer une Facture
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Filters -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('gym.invoices.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Numéro ou Client..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Statut</label>
                    <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Non Payé</option>
                        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partiel</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En Retard</option>
                    </select>
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors h-[38px]">
                    Filtrer
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 pl-6">N° Facture</th>
                            <th class="py-4">Client</th>
                            <th class="py-4">Date</th>
                            <th class="py-4">Montant</th>
                            <th class="py-4">Reste à Payer</th>
                            <th class="py-4">Statut</th>
                            <th class="py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 pl-6 font-mono text-sm text-indigo-600 font-medium">
                                <a href="{{ route('gym.invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a>
                            </td>
                            <td class="py-4">
                                @if($invoice->member)
                                    <div class="font-bold text-gray-900 text-sm">{{ $invoice->member->full_name }}</div>
                                @else
                                    <span class="text-gray-400 italic">Client Passager</span>
                                @endif
                            </td>
                            <td class="py-4 text-sm text-gray-600">
                                {{ $invoice->issue_date->format('d/m/Y') }}
                            </td>
                            <td class="py-4 font-bold text-gray-900">
                                {{ number_format($invoice->total_amount, 2) }} MAD
                            </td>
                            <td class="py-4 text-sm">
                                @if($invoice->balance > 0)
                                    <span class="text-red-600 font-medium">{{ number_format($invoice->balance, 2) }} MAD</span>
                                @else
                                    <span class="text-green-600 font-medium">0.00 MAD</span>
                                @endif
                            </td>
                            <td class="py-4">
                                @php
                                    $statusColors = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'partial' => 'bg-yellow-100 text-yellow-800',
                                        'unpaid' => 'bg-red-100 text-red-800',
                                        'overdue' => 'bg-red-100 text-red-800 font-bold',
                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusLabels = [
                                        'paid' => 'Payé',
                                        'partial' => 'Partiel',
                                        'unpaid' => 'Non Payé',
                                        'overdue' => 'En Retard',
                                        'cancelled' => 'Annulé',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$invoice->status] ?? ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td class="py-4 text-center">
                                <a href="{{ route('gym.invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Détails</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                Aucune facture trouvée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
    </div>
</x-gym-layout>
