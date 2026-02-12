<x-gym-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $equipment->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('gym.equipment.edit', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                    Modifier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Equipment Info -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        @if($equipment->photo_path)
                            <img src="{{ asset('uploads/' . $equipment->photo_path) }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-4">Détails</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Marque</span>
                                    <span class="font-medium">{{ $equipment->brand ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Modèle</span>
                                    <span class="font-medium">{{ $equipment->model ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Acheté le</span>
                                    <span class="font-medium">{{ $equipment->purchase_date?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Prix</span>
                                    <span class="font-medium">{{ $equipment->price ? number_format($equipment->price, 2) . ' MAD' : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Fin Garantie</span>
                                    <span class="font-medium {{ $equipment->warranty_expiry && $equipment->warranty_expiry < now() ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $equipment->warranty_expiry?->format('d/m/Y') ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Statut</span>
                                    <span class="font-bold uppercase 
                                        @if($equipment->status == 'active') text-green-600
                                        @elseif($equipment->status == 'maintenance') text-yellow-600
                                        @elseif($equipment->status == 'broken') text-red-600
                                        @else text-gray-600 @endif">
                                        {{ $equipment->status }}
                                    </span>
                                </div>
                            </div>
                            @if($equipment->notes)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notes</h4>
                                    <p class="text-gray-600 text-sm">{{ $equipment->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Maintenance Logs -->
                <div class="md:col-span-2">
                    <!-- Maintenance History -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Historique de Maintenance</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-50 text-gray-500 uppercase font-bold">
                                        <tr>
                                            <th class="px-4 py-3">Date</th>
                                            <th class="px-4 py-3">Titre</th>
                                            <th class="px-4 py-3">Coût</th>
                                            <th class="px-4 py-3">Par</th>
                                            <th class="px-4 py-3">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($equipment->maintenanceLogs as $log)
                                            <tr>
                                                <td class="px-4 py-3">{{ $log->maintenance_date->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="font-medium text-gray-900">{{ $log->title }}</div>
                                                    <div class="text-xs text-gray-500">{{ Str::limit($log->description, 50) }}</div>
                                                </td>
                                                <td class="px-4 py-3 font-bold text-red-600">-{{ number_format($log->cost, 2) }}</td>
                                                <td class="px-4 py-3">{{ $log->performed_by ?? '-' }}</td>
                                                <td class="px-4 py-3">
                                                    @if($log->status === 'completed')
                                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">Terminé</span>
                                                    @else
                                                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs">{{ ucfirst($log->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Aucune maintenance enregistrée.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Add Maintenance Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Enregistrer une Maintenance</h3>
                            <form action="{{ route('gym.equipment.maintenance.store', $equipment) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                                        <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="maintenance_date" value="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Coût (MAD)</label>
                                        <input type="number" step="0.01" name="cost" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Intervenant</label>
                                        <input type="text" name="performed_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="completed">Terminé</option>
                                            <option value="in_progress">En cours</option>
                                            <option value="pending">Prévu</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                                <div class="mt-4 text-right">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
