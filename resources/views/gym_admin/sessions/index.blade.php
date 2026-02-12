<x-gym-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Calendrier des Séances</h2>
                <p class="text-sm text-gray-500">Gérez les séances d'entraînement</p>
            </div>
            <a href="{{ route('gym.sessions.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Planifier une Séance
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- Date Filter -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('gym.sessions.index') }}" class="flex items-end gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date', now()->format('Y-m-d')) }}" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors h-[38px]">
                    Afficher
                </button>
                @if(request('date'))
                    <a href="{{ route('gym.sessions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline h-[38px] flex items-center">
                        Voir tout (futur)
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 pl-6">Séance</th>
                            <th class="py-4">Type</th>
                            <th class="py-4">Horaire</th>
                            <th class="py-4">Entraîneur</th>
                            <th class="py-4">Capacité</th>
                            <th class="py-4">Statut</th>
                            <th class="py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 pl-6">
                                <div class="font-bold text-gray-900 text-sm">{{ $session->name }}</div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $session->trainingType->name }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-gray-600">
                                <div class="font-medium">{{ $session->start_time->translatedFormat('D d M Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                                </div>
                            </td>
                            <td class="py-4 text-sm">
                                @if($session->trainer)
                                    <div class="flex items-center gap-2">
                                        @if($session->trainer->photo_path)
                                            <img src="{{ asset('uploads/' . $session->trainer->photo_path) }}" class="w-6 h-6 rounded-full object-cover">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600 font-bold">
                                                {{ substr($session->trainer->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span>{{ $session->trainer->full_name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Non assigné</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ min(($session->confirmedBookings()->count() / $session->capacity) * 100, 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $session->confirmedBookings()->count() }}/{{ $session->capacity }}</span>
                                </div>
                            </td>
                            <td class="py-4">
                                @if($session->status === 'scheduled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Prévue</span>
                                @elseif($session->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Annulée</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Terminée</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('gym.sessions.edit', $session) }}" class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('gym.sessions.destroy', $session) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?');" class="inline">
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
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <p>Aucune séance trouvée pour cette date.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sessions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $sessions->links() }}
            </div>
            @endif
        </div>
    </div>
</x-gym-layout>
