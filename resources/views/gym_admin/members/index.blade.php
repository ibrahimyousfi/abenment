<x-gym-layout>
    <div x-data="memberManagement()">
        <x-slot name="header">
            <div class="flex items-center justify-between w-full gap-4">
                <h2 class="font-bold text-xl text-gray-900 leading-tight whitespace-nowrap hidden md:block">
                    {{ __('Gestion des Membres') }}
                </h2>
                <div class="flex-1 w-full max-w-3xl">
                    <form method="GET" action="{{ route('gym.members.index') }}" class="w-full">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher un membre (Nom, CIN...)"
                                   class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition duration-150 ease-in-out">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('gym.members.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('gym.members.export', request()->all()) }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Export
                    </a>
                    <a href="{{ route('gym.members.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 whitespace-nowrap shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Ajouter Membre') }}</span>
                        <span class="sm:hidden">{{ __('Ajouter') }}</span>
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Bulk Actions Bar -->
                <div x-show="selectedIds.length > 0" x-transition class="mb-4 bg-indigo-50 border border-indigo-100 p-4 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-2 text-indigo-700 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span x-text="selectedIds.length + ' membres sélectionnés'"></span>
                    </div>
                    <form action="{{ route('gym.members.bulk_message') }}" method="POST" class="flex gap-2">
                        @csrf
                        <template x-for="id in selectedIds" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <input type="text" name="message" placeholder="Message à envoyer..." class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                            Envoyer SMS
                        </button>
                    </form>
                </div>

                <!-- Filters -->
                <div class="mb-6 bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                    <div class="flex flex-col gap-6">
                        <!-- Date Range Filter -->
                        <div class="flex flex-wrap items-end gap-4 pb-4 border-b border-gray-100">
                            <div class="w-full md:w-auto">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Expiration Du</label>
                                <input type="date" name="expiry_start" form="filterForm" value="{{ request('expiry_start') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="w-full md:w-auto">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Au</label>
                                <input type="date" name="expiry_end" form="filterForm" value="{{ request('expiry_end') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <button type="submit" form="filterForm" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors h-[38px]">
                                Filtrer Dates
                            </button>

                            <!-- Hidden Form for Date Filter to work with GET -->
                            <form id="filterForm" method="GET" action="{{ route('gym.members.index') }}" class="hidden">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <input type="hidden" name="training_type_id" value="{{ request('training_type_id') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            </form>
                        </div>

                        <!-- Status & Discipline Filters -->
                        <div class="flex flex-col lg:flex-row gap-6 justify-between items-start lg:items-center">
                            <!-- Filters Grid -->
                            <div class="flex flex-col gap-4 w-full">
                                <!-- Status Filters -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2">Statut:</span>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                                       class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ !request('status') || request('status') == 'all' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        Tous ({{ $counts['status']['all'] }})
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                                       class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ request('status') == 'active' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-white border border-gray-200 text-gray-500 hover:border-emerald-200 hover:text-emerald-600' }}">
                                        Actif ({{ $counts['status']['active'] }})
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'expired']) }}"
                                       class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ request('status') == 'expired' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-white border border-gray-200 text-gray-500 hover:border-red-200 hover:text-red-600' }}">
                                        Expiré ({{ $counts['status']['expired'] }})
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                                       class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ request('status') == 'inactive' ? 'bg-gray-200 text-gray-700' : 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-50' }}">
                                        Inactif ({{ $counts['status']['inactive'] }})
                                    </a>
                                </div>

                                <!-- Discipline Filters -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2">Discipline:</span>
                                    <a href="{{ request()->fullUrlWithQuery(['training_type_id' => '']) }}"
                                       class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ !request('training_type_id') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        Tous ({{ $counts['training_type']['all'] }})
                                    </a>
                                    @foreach($trainingTypes as $type)
                                        <a href="{{ request()->fullUrlWithQuery(['training_type_id' => $type->id]) }}"
                                           class="px-3 py-1.5 text-xs rounded-full font-bold uppercase tracking-wider transition {{ request('training_type_id') == $type->id ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-white border border-gray-200 text-gray-500 hover:border-indigo-200 hover:text-indigo-600' }}">
                                            {{ $type->name }} ({{ $counts['training_type'][$type->id] ?? 0 }})
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Members Grid/Table -->
                <div class="bg-white border border-gray-100 overflow-hidden shadow-sm rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="py-4 pl-6 w-10">
                                        <input type="checkbox" @change="toggleAll" x-model="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="py-4 pl-2">Membre</th>
                                    <th class="py-4">Contact</th>
                                    <th class="py-4">Statut</th>
                                    <th class="py-4">Abonnement Actuel</th>
                                    <th class="py-4">Expire le</th>
                                    <th class="py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($members as $member)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 pl-6">
                                        <input type="checkbox" value="{{ $member->id }}" x-model="selectedIds" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </td>
                                    <!-- Member Info with Photo -->
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            @if($member->photo_path)
                                                <img src="{{ asset('uploads/' . $member->photo_path) }}"
                                                     class="w-10 h-10 rounded-full object-cover border border-gray-200"
                                                     alt="{{ $member->full_name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 text-indigo-600 font-bold text-sm">
                                                    {{ substr($member->full_name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-gray-900 text-sm">{{ $member->full_name }}</div>
                                                <div class="text-xs text-gray-500 font-mono">CIN: {{ $member->cin }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact -->
                                    <td class="py-4">
                                        <div class="text-sm text-gray-600 font-mono">{{ $member->phone ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-400 capitalize">{{ $member->gender == 'male' ? 'Homme' : 'Femme' }}</div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4">
                                        @php $status = $member->status; @endphp
                                        <span class="px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide rounded-full
                                            {{ $status == 'Active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                            {{ $status == 'Expired' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ $status == 'Inactive' ? 'bg-gray-100 text-gray-600' : '' }}
                                        ">
                                            @if($status == 'Active') ACTIF
                                            @elseif($status == 'Expired') EXPIRÉ
                                            @else INACTIF
                                            @endif
                                        </span>
                                    </td>

                                    <!-- Current Plan -->
                                    <td class="py-4">
                                        @php
                                            $activeSub = $member->subscriptions->where('end_date', '>=', now()->toDateString())->sortByDesc('end_date')->first();
                                            $latestSub = $member->subscriptions->sortByDesc('end_date')->first();
                                            $displaySub = $activeSub ?? $latestSub;
                                        @endphp
                                        @if($displaySub)
                                            <div class="flex items-center gap-2">
                                                <div>
                                                    <div class="text-sm font-bold {{ !$activeSub ? 'text-gray-500' : 'text-gray-900' }}">
                                                        {{ $displaySub->plan->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $displaySub->plan->trainingType->name }}</div>
                                                </div>
                                                <!-- Edit Subscription Button -->
                                                <button @click="openModal('edit', {{ json_encode($member) }}, {{ json_encode($displaySub) }})"
                                                        class="p-1 text-gray-400 hover:text-indigo-600 rounded-full hover:bg-indigo-50 transition"
                                                        title="Modifier l'abonnement">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm italic">Aucun plan</span>
                                        @endif
                                    </td>

                                    <!-- Expiration -->
                                    <td class="py-4">
                                        @if($displaySub)
                                            @php
                                                $daysLeft = now()->startOfDay()->diffInDays($displaySub->end_date, false);
                                                $isExpiringSoon = $daysLeft <= 7 && $daysLeft >= 0;
                                                $isExpired = $daysLeft < 0;
                                            @endphp
                                            <div class="text-sm font-mono {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-orange-600 font-bold' : 'text-gray-600') }}">
                                                {{ $displaySub->end_date->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs {{ $isExpired ? 'text-red-500' : ($isExpiringSoon ? 'text-orange-500' : 'text-gray-400') }}">
                                                @if($isExpired)
                                                    (Expiré)
                                                @else
                                                    ({{ intval($daysLeft) }} jours restants)
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Renew Button -->
                                            <button @click="openModal('renew', {{ json_encode($member) }})"
                                                    class="inline-flex items-center px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-lg text-xs font-semibold text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 transition">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                                Renouveler
                                            </button>

                                            <!-- View -->
                                            <a href="{{ route('gym.members.show', $member) }}"
                                               class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                               title="Voir Détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            <!-- Edit Member -->
                                            <a href="{{ route('gym.members.edit', $member) }}"
                                               class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                               title="Éditer Membre">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <!-- WhatsApp -->
                                            @if($member->phone)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank"
                                                   class="p-1.5 text-green-500 hover:text-green-700 hover:bg-green-50 rounded-lg transition"
                                                   title="WhatsApp">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                </a>
                                            @endif

                                            <!-- Delete Button -->
                                            <button @click="openDeleteModal({{ $member->id }})" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Supprimer le membre">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            </div>
                                            <p class="font-medium">Aucun membre trouvé.</p>
                                            <p class="text-sm mt-1">Essayez d'ajuster vos filtres ou ajoutez un nouveau membre.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Subscription Modal -->
            <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="closeModal"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="modalTitle"></h3>
                                    <div class="mt-2">
                                        <form :action="formAction" method="POST" id="subscriptionForm">
                                            @csrf
                                            <template x-if="mode === 'edit'">
                                                <input type="hidden" name="_method" value="PUT">
                                            </template>

                                            <!-- Member Name -->
                                            <div class="mb-4">
                                                <p class="text-sm text-gray-500">Membre: <span class="font-bold text-gray-900" x-text="selectedMember?.full_name"></span></p>
                                            </div>

                                            <!-- Plan Selection -->
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Plan</label>
                                                <select name="plan_id" x-model="formData.plan_id" @change="updatePlanDetails" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                    <option value="">Sélectionner un plan</option>
                                                    @foreach($trainingTypes as $type)
                                                        <optgroup label="{{ $type->name }}">
                                                            @foreach($type->plans as $plan)
                                                                <option value="{{ $plan->id }}"
                                                                    data-price="{{ $plan->price }}"
                                                                    data-days="{{ $plan->duration_days }}">
                                                                    {{ $plan->name }} - {{ $plan->price }} MAD
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mb-4">
                                                <!-- Start Date -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Date Début</label>
                                                    <input type="date" name="start_date" x-model="formData.start_date" @change="calculateEndDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                </div>

                                                <!-- End Date -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Date Fin</label>
                                                    <input type="date" name="end_date" x-model="formData.end_date" @change="calculateDuration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                </div>
                                            </div>

                                            <!-- Auto Calc Info -->
                                            <div class="mb-4 text-xs text-gray-500 bg-gray-50 p-2 rounded flex justify-between">
                                                <span>Durée: <span class="font-bold" x-text="duration + ' jours'"></span></span>
                                            </div>

                                            <!-- Price -->
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Prix (MAD)</label>
                                                <input type="number" step="0.01" name="price" x-model="formData.price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                            </div>

                                            <!-- Payment Method (Only for Renew) -->
                                            <template x-if="mode === 'renew'">
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">Méthode de Paiement</label>
                                                    <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                        <option value="cash">Espèces (Cash)</option>
                                                        <option value="card">Carte Bancaire</option>
                                                        <option value="transfer">Virement</option>
                                                    </select>
                                                </div>
                                            </template>

                                            <!-- Notes -->
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Notes (Optionnel)</label>
                                                <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" form="subscriptionForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <span x-text="mode === 'renew' ? 'Confirmer le Renouvellement' : 'Enregistrer les Modifications'"></span>
                            </button>
                            <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="closeDeleteModal"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Supprimer le membre</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer ce membre ? Cette action est irréversible.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <form :action="deleteAction" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Supprimer
                                </button>
                            </form>
                            <button type="button" @click="closeDeleteModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function memberManagement() {
            return {
                selectedIds: [],
                allSelected: false,
                showModal: false,
                showDeleteModal: false,
                deleteAction: '',
                mode: 'renew', // renew or edit
                selectedMember: null,
                selectedSubscription: null,
                modalTitle: '',
                formAction: '',
                formData: {
                    plan_id: '',
                    start_date: new Date().toISOString().split('T')[0],
                    end_date: '',
                    price: ''
                },
                duration: 0,

                toggleAll() {
                    this.selectedIds = [];
                    if (this.allSelected) {
                        document.querySelectorAll('input[type="checkbox"][value]').forEach(el => {
                            this.selectedIds.push(el.value);
                        });
                    }
                },

                openDeleteModal(id) {
                    this.deleteAction = `/gym-admin/members/${id}`;
                    this.showDeleteModal = true;
                },

                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.deleteAction = '';
                },

                openModal(mode, member, subscription = null) {
                    this.mode = mode;
                    this.selectedMember = member;
                    this.selectedSubscription = subscription;
                    this.showModal = true;

                    if (mode === 'renew') {
                        this.modalTitle = 'Renouveler l\'abonnement';
                        this.formAction = `/gym-admin/members/${member.id}/renew`; // Ensure this route matches
                        this.formData = {
                            plan_id: '',
                            start_date: new Date().toISOString().split('T')[0],
                            end_date: '',
                            price: ''
                        };
                        this.duration = 0;
                    } else {
                        this.modalTitle = 'Modifier l\'abonnement';
                        this.formAction = `/gym-admin/subscriptions/${subscription.id}`;
                        this.formData = {
                            plan_id: subscription.plan_id,
                            start_date: subscription.start_date.split('T')[0], // Assuming ISO format from backend
                            end_date: subscription.end_date.split('T')[0],
                            price: subscription.price_snapshot
                        };
                        this.calculateDuration();
                    }
                },

                closeModal() {
                    this.showModal = false;
                    this.selectedMember = null;
                    this.selectedSubscription = null;
                },

                updatePlanDetails(event) {
                    const selectedOption = event.target.options[event.target.selectedIndex];
                    const price = selectedOption.dataset.price;
                    const days = parseInt(selectedOption.dataset.days);

                    this.formData.price = price;

                    if (this.formData.start_date && days) {
                        const startDate = new Date(this.formData.start_date);
                        const endDate = new Date(startDate);
                        endDate.setDate(startDate.getDate() + days);
                        this.formData.end_date = endDate.toISOString().split('T')[0];
                        this.duration = days;
                    }
                },

                calculateEndDate() {
                    // Re-calculate end date if plan is selected and start date changes
                    const planSelect = document.querySelector('select[name="plan_id"]');
                    if (planSelect && planSelect.selectedIndex > 0) {
                        const days = parseInt(planSelect.options[planSelect.selectedIndex].dataset.days);
                        if (this.formData.start_date && days) {
                            const startDate = new Date(this.formData.start_date);
                            const endDate = new Date(startDate);
                            endDate.setDate(startDate.getDate() + days);
                            this.formData.end_date = endDate.toISOString().split('T')[0];
                            this.duration = days;
                        }
                    } else {
                        this.calculateDuration();
                    }
                },

                calculateDuration() {
                    if (this.formData.start_date && this.formData.end_date) {
                        const start = new Date(this.formData.start_date);
                        const end = new Date(this.formData.end_date);
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        this.duration = diffDays;

                        // Validation logic could go here (e.g. check if end < start)
                        if (end < start) {
                            alert('La date de fin doit être postérieure à la date de début.');
                            this.formData.end_date = '';
                            this.duration = 0;
                        }
                    }
                }
            }
        }
    </script>
</x-gym-layout>
