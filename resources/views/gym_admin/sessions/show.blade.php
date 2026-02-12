<x-gym-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la Séance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Session Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $session->name }}</h3>
                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-600">
                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded">{{ $session->trainingType->name }}</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $session->start_time->translatedFormat('l d F Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                                </span>
                            </div>
                            @if($session->trainer)
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-sm text-gray-500">Entraîneur:</span>
                                    <span class="font-medium text-gray-900">{{ $session->trainer->full_name }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold {{ $session->is_full ? 'text-red-600' : 'text-green-600' }}">
                                {{ $session->bookings->where('status', 'confirmed')->count() }} / {{ $session->capacity }}
                            </div>
                            <p class="text-sm text-gray-500">Inscrits</p>
                            @if($session->bookings->where('status', 'waiting')->count() > 0)
                                <p class="text-sm text-orange-500 font-medium mt-1">
                                    {{ $session->bookings->where('status', 'waiting')->count() }} en attente
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bookings List -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Participants</h4>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membre</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($session->bookings as $booking)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="text-sm font-medium text-gray-900">{{ $booking->member->full_name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    @if($booking->status === 'confirmed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmé</span>
                                                    @elseif($booking->status === 'waiting')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">En attente</span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($booking->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    <form action="{{ route('gym.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Annuler cette réservation ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Annuler</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-3 text-center text-gray-500">Aucun participant inscrit.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Participant Form -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Ajouter un Participant</h4>

                            <form action="{{ route('gym.sessions.book', $session) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="member_id" class="block text-sm font-medium text-gray-700">Sélectionner un membre</label>
                                    <select name="member_id" id="member_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                        <option value="">-- Choisir un membre --</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->status }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Inscrire
                                </button>

                                <p class="mt-4 text-xs text-gray-500">
                                    Si la séance est complète, le membre sera automatiquement ajouté à la <strong>liste d'attente</strong>.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
