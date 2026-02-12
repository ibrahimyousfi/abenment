<x-gym-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Gestion des Entraîneurs</h2>
                <p class="text-sm text-gray-500">Gérez votre équipe d'entraîneurs</p>
            </div>
            <a href="{{ route('gym.trainers.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Ajouter un Entraîneur
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-4 pl-6">Entraîneur</th>
                            <th class="py-4">Spécialisation</th>
                            <th class="py-4">Contact</th>
                            <th class="py-4">Statut</th>
                            <th class="py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($trainers as $trainer)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 pl-6">
                                <div class="flex items-center gap-3">
                                    @if($trainer->photo_path)
                                        <img src="{{ asset('uploads/' . $trainer->photo_path) }}" 
                                             class="w-10 h-10 rounded-full object-cover border border-gray-200"
                                             alt="{{ $trainer->full_name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 text-indigo-600 font-bold text-sm">
                                            {{ substr($trainer->full_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $trainer->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-sm text-gray-600">
                                {{ $trainer->specialization ?? '-' }}
                            </td>
                            <td class="py-4">
                                <div class="flex flex-col gap-1">
                                    @if($trainer->phone)
                                        <span class="inline-flex items-center text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md w-fit">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            {{ $trainer->phone }}
                                        </span>
                                    @endif
                                    @if($trainer->email)
                                        <span class="inline-flex items-center text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-md w-fit">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            {{ $trainer->email }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4">
                                @if($trainer->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('gym.trainers.edit', $trainer) }}" class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('gym.trainers.destroy', $trainer) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet entraîneur ?');" class="inline">
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
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    <p>Aucun entraîneur trouvé.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($trainers->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $trainers->links() }}
            </div>
            @endif
        </div>
    </div>
</x-gym-layout>
