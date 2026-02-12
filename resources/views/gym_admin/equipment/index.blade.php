<x-gym-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Gestion des Équipements</h2>
                <p class="text-sm text-gray-500">Gérez votre matériel et suivez la maintenance</p>
            </div>
            <a href="{{ route('gym.equipment.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Ajouter Équipement
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Filters -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('gym.equipment.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, marque..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Statut</label>
                    <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>En Maintenance</option>
                        <option value="broken" {{ request('status') == 'broken' ? 'selected' : '' }}>Hors Service</option>
                        <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>Retiré</option>
                    </select>
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors h-[38px]">
                    Filtrer
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($equipment as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if($item->photo_path)
                            <img src="{{ asset('uploads/' . $item->photo_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'maintenance' => 'bg-yellow-100 text-yellow-800',
                                    'broken' => 'bg-red-100 text-red-800',
                                    'retired' => 'bg-gray-100 text-gray-800',
                                ];
                                $statusLabels = [
                                    'active' => 'Actif',
                                    'maintenance' => 'Maintenance',
                                    'broken' => 'Hors Service',
                                    'retired' => 'Retiré',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$item->status] ?? ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $item->brand }} {{ $item->model ? '- ' . $item->model : '' }}</p>
                        
                        <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $item->purchase_date ? $item->purchase_date->format('d/m/Y') : '-' }}
                            </span>
                            @if($item->warranty_expiry && $item->warranty_expiry > now())
                                <span class="text-green-600 text-xs font-medium bg-green-50 px-2 py-1 rounded">Garantie OK</span>
                            @elseif($item->warranty_expiry)
                                <span class="text-red-600 text-xs font-medium bg-red-50 px-2 py-1 rounded">Garantie Exp.</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('gym.equipment.show', $item) }}" class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-2 rounded-lg text-sm font-bold transition-colors">
                                Détails & Maintenance
                            </a>
                            <a href="{{ route('gym.equipment.edit', $item) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-100">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        <p>Aucun équipement trouvé.</p>
                        <a href="{{ route('gym.equipment.create') }}" class="mt-4 text-indigo-600 font-medium hover:underline">Ajouter votre premier équipement</a>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($equipment->hasPages())
        <div class="mt-6">
            {{ $equipment->links() }}
        </div>
        @endif
    </div>
</x-gym-layout>
