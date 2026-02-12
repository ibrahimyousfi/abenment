<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Renouveler l'abonnement</h1>
                <p class="text-gray-500 text-sm mt-1">Membre : {{ $member->full_name }}</p>
            </div>
            <a href="{{ route('members.show', $member) }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Annuler
            </a>
        </div>

        <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-8">
                
                <!-- Current Status Banner -->
                <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-200 flex items-start gap-4">
                    <div class="bg-white p-2 rounded-full shadow-sm">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Statut Actuel</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Le statut actuel du membre est 
                            <span class="font-bold px-2 py-0.5 rounded text-xs uppercase
                                {{ $member->status == 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $member->status == 'Active' ? 'ACTIF' : 'EXPIRÉ/INACTIF' }}
                            </span>
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('members.storeRenewal', $member) }}" class="space-y-8">
                    @csrf

                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-100">
                            <div class="bg-indigo-50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Détails du Renouvellement</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Plan -->
                            <div>
                                <label for="plan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Choisir le nouveau plan <span class="text-red-500">*</span>
                                </label>
                                <select id="plan_id" 
                                        name="plan_id" 
                                        required
                                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                    <option value="">-- Sélectionner un plan --</option>
                                    @foreach($trainingTypes as $type)
                                        <optgroup label="{{ $type->name }}">
                                            @foreach($type->plans as $plan)
                                                <option value="{{ $plan->id }}" {{ old('plan_id', $member->subscriptions->last()?->plan_id) == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->name }} - {{ $plan->duration_days }} jours ({{ $plan->price }} MAD)
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Date de début <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $lastSub = $member->subscriptions->sortByDesc('end_date')->first();
                                    $suggestedDate = $lastSub && $lastSub->end_date->isFuture() 
                                        ? $lastSub->end_date->addDay()->format('Y-m-d') 
                                        : date('Y-m-d');
                                @endphp
                                <input id="start_date" 
                                       type="date" 
                                       name="start_date" 
                                       value="{{ old('start_date', $suggestedDate) }}" 
                                       required
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                <p class="mt-1 text-xs text-gray-500">Suggéré : commence après la fin de l'abonnement précédent.</p>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('members.show', $member) }}" 
                           class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 text-sm">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Confirmer le renouvellement
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>