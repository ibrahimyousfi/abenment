<x-super-admin-layout>
    <div class="space-y-8" x-data="gymManagement()">
        
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="$el.parentElement.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Salles de Sport</h1>
                <p class="text-gray-500 mt-1">Gérer toutes les salles de sport enregistrées</p>
            </div>
            <div class="flex gap-2">
                <!-- Bulk Actions -->
                <div x-show="selectedIds.length > 0" x-transition class="flex items-center gap-2">
                    <span class="text-sm text-gray-600" x-text="selectedIds.length + ' sélectionné(s)'"></span>
                    <form action="{{ route('super_admin.gyms.bulk_destroy') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces éléments ?');">
                        @csrf
                        <template x-for="id in selectedIds" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Supprimer la sélection
                        </button>
                    </form>
                </div>

                <a href="{{ route('super_admin.gyms.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Ajouter une salle
                </a>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form method="GET" action="{{ route('super_admin.gyms.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom..." class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="w-full md:w-48">
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="w-full md:w-48">
                    <select name="trashed" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Actifs seulement</option>
                        <option value="with" {{ request('trashed') == 'with' ? 'selected' : '' }}>Avec supprimés</option>
                        <option value="only" {{ request('trashed') == 'only' ? 'selected' : '' }}>Supprimés seulement</option>
                    </select>
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- Gyms List Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" @change="toggleAll" x-model="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom de la Salle</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">État</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Expiration</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($gyms as $gym)
                        <tr class="hover:bg-gray-50 transition-colors {{ $gym->trashed() ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $gym->id }}" x-model="selectedIds" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($gym->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $gym->name }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ $gym->id }}</div>
                                        @if($gym->trashed())
                                            <span class="text-xs text-red-600 font-bold">(Supprimé)</span>
                                        @endif
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
                                        Expiré / Inactif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $gym->subscription_expires_at ? $gym->subscription_expires_at->format('d M, Y') : 'N/A' }}
                                </div>
                                @if($gym->subscription_expires_at && $gym->subscription_expires_at->diffInDays(now()) <= 7 && !$gym->trashed())
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
                                    @if($gym->trashed())
                                        <form action="{{ route('super_admin.gyms.restore', $gym->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 text-xs font-bold" title="Restaurer">
                                                Restaurer
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('super_admin.gyms.show', $gym) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Voir détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('super_admin.gyms.edit', $gym) }}" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('super_admin.gyms.destroy', $gym) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ? Elle sera déplacée vers la corbeille.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Aucun résultat trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-100">
                {{ $gyms->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script>
        function gymManagement() {
            return {
                selectedIds: [],
                allSelected: false,
                toggleAll() {
                    this.selectedIds = [];
                    if (this.allSelected) {
                        // Select all checkboxes on the current page
                        document.querySelectorAll('input[type="checkbox"][value]').forEach(el => {
                            this.selectedIds.push(el.value);
                        });
                    }
                }
            }
        }
    </script>
</x-super-admin-layout>
