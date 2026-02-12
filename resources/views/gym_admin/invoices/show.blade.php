<x-gym-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Facture #{{ $invoice->invoice_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('gym.invoices.pdf', $invoice) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                    Imprimer PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Invoice Details -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h1 class="text-4xl font-bold text-gray-900 mb-2">FACTURE</h1>
                                    <p class="text-gray-500">N° {{ $invoice->invoice_number }}</p>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-lg font-bold text-gray-900">{{ auth()->user()->gym->name }}</h3>
                                    <p class="text-sm text-gray-500">Date d'émission: {{ $invoice->issue_date->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">Date d'échéance: {{ $invoice->due_date->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <!-- Client Info -->
                            <div class="mb-8 border-t border-gray-100 pt-8">
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Facturé à</h4>
                                @if($invoice->member)
                                    <p class="text-lg font-bold text-gray-900">{{ $invoice->member->full_name }}</p>
                                    <p class="text-gray-600">{{ $invoice->member->email }}</p>
                                    <p class="text-gray-600">{{ $invoice->member->phone }}</p>
                                @else
                                    <p class="text-lg font-bold text-gray-900 italic">Client Passager</p>
                                @endif
                            </div>

                            <!-- Amounts -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-medium text-gray-600">Montant Total</span>
                                    <span class="text-xl font-bold text-gray-900">{{ number_format($invoice->total_amount, 2) }} MAD</span>
                                </div>
                                <div class="flex justify-between items-center mb-4 text-green-600">
                                    <span class="font-medium">Montant Payé</span>
                                    <span class="font-bold">- {{ number_format($invoice->paid_amount, 2) }} MAD</span>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-200 text-red-600">
                                    <span class="font-bold text-lg">Reste à Payer</span>
                                    <span class="font-bold text-2xl">{{ number_format($invoice->balance, 2) }} MAD</span>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                <span class="px-4 py-2 rounded-full text-sm font-bold 
                                    @if($invoice->status == 'paid') bg-green-100 text-green-800
                                    @elseif($invoice->status == 'partial') bg-yellow-100 text-yellow-800
                                    @elseif($invoice->status == 'overdue') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    Statut: {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Historique des Paiements</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-50 text-gray-500 uppercase font-bold">
                                        <tr>
                                            <th class="px-4 py-3">Date</th>
                                            <th class="px-4 py-3">Méthode</th>
                                            <th class="px-4 py-3">Montant</th>
                                            <th class="px-4 py-3">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($invoice->payments as $payment)
                                            <tr>
                                                <td class="px-4 py-3">{{ $payment->payment_date->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3 capitalize">{{ $payment->payment_method }}</td>
                                                <td class="px-4 py-3 font-bold text-green-600">{{ number_format($payment->amount, 2) }} MAD</td>
                                                <td class="px-4 py-3 text-gray-500">{{ $payment->notes ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">Aucun paiement enregistré.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Payment Form -->
                <div class="md:col-span-1">
                    @if($invoice->balance > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Enregistrer un Paiement</h3>
                            <form action="{{ route('gym.invoices.payment', $invoice) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Montant (MAD)</label>
                                        <input type="number" step="0.01" name="amount" value="{{ $invoice->balance }}" max="{{ $invoice->balance }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Méthode</label>
                                        <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="cash">Espèces</option>
                                            <option value="card">Carte Bancaire</option>
                                            <option value="transfer">Virement</option>
                                            <option value="check">Chèque</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Note (Optionnel)</label>
                                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                        Confirmer le Paiement
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
