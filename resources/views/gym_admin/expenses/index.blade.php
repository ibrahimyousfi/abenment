<x-gym-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dépenses</h2>
                <p class="text-sm text-gray-500">Suivez les dépenses de votre salle</p>
            </div>
            <a href="{{ route('gym.expenses.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Ajouter une Dépense
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Filters -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('gym.expenses.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catégorie</label>
                    <select name="category" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes</option>
                        <option value="rent" {{ request('category') == 'rent' ? 'selected' : '' }}>Loyer</option>
                        <option value="salary" {{ request('category') == 'salary' ? 'selected' : '' }}>Salaire</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Équipement</option>
                        <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="utilities" {{ request('category') == 'utilities' ? 'selected' : '' }}>Charges (Eau/Élec)</option>
                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Du</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Au</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <th class="py-4 pl-6">Titre</th>
                            <th class="py-4">Catégorie</th>
                            <th class="py-4">Date</th>
                            <th class="py-4">Montant</th>
                            <th class="py-4">Pièce jointe</th>
                            <th class="py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 pl-6 font-medium text-gray-900">
                                {{ $expense->title }}
                            </td>
                            <td class="py-4">
                                @php
                                    $categories = [
                                        'rent' => 'Loyer',
                                        'salary' => 'Salaire',
                                        'equipment' => 'Équipement',
                                        'maintenance' => 'Maintenance',
                                        'utilities' => 'Charges',
                                        'other' => 'Autre',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $categories[$expense->category] ?? ucfirst($expense->category) }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-600">
                                {{ $expense->expense_date->format('d/m/Y') }}
                            </td>
                            <td class="py-4 font-bold text-red-600">
                                - {{ number_format($expense->amount, 2) }} MAD
                            </td>
                            <td class="py-4 text-sm">
                                @if($expense->attachment_path)
                                    <a href="{{ asset('uploads/' . $expense->attachment_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 underline">Voir</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('gym.expenses.edit', $expense) }}" class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('gym.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                Aucune dépense enregistrée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($expenses->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $expenses->links() }}
            </div>
            @endif
        </div>
    </div>
</x-gym-layout>
