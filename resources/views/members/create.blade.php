<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ajouter un Membre</h1>
                <p class="text-gray-500 text-sm mt-1">Inscrire un nouveau membre et assigner un abonnement.</p>
            </div>
            <a href="{{ route('members.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Annuler
            </a>
        </div>

        <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-8">

                <form method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Personal Information Section -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-100">
                            <div class="bg-indigo-50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Informations Personnelles</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nom Complet <span class="text-red-500">*</span>
                                </label>
                                <input id="full_name"
                                       type="text"
                                       name="full_name"
                                       value="{{ old('full_name') }}"
                                       required
                                       autofocus
                                       placeholder="Ex: Mohammed Alami"
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CIN -->
                            <div>
                                <label for="cin" class="block text-sm font-semibold text-gray-700 mb-2">
                                    CIN <span class="text-red-500">*</span>
                                </label>
                                <input id="cin"
                                       type="text"
                                       name="cin"
                                       value="{{ old('cin') }}"
                                       required
                                       placeholder="Ex: AB123456"
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                @error('cin')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Numéro de Téléphone
                                </label>
                                <input id="phone"
                                       type="text"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="+212 6XX XXX XXX"
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sexe <span class="text-red-500">*</span>
                                </label>
                                <select id="gender"
                                        name="gender"
                                        required
                                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Photo -->
                            <div>
                                <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Photo (Optionnel)
                                </label>
                                <input id="photo"
                                       type="file"
                                       name="photo"
                                       accept="image/*"
                                       class="w-full text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Section -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-100">
                            <div class="bg-indigo-50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Abonnement Initial</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Plan -->
                            <div>
                                <label for="plan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sélectionner un Plan <span class="text-red-500">*</span>
                                </label>
                                <select id="plan_id"
                                        name="plan_id"
                                        required
                                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                    <option value="">-- Choisir un Plan --</option>
                                    @foreach($trainingTypes as $type)
                                        <optgroup label="{{ $type->name }}">
                                            @foreach($type->plans as $plan)
                                                @php
                                                    $isSelected = old('plan_id') == $plan->id ||
                                                                ($preselectedPlanId == $plan->id) ||
                                                                (isset($preselectedTrainingTypeId) && $preselectedTrainingTypeId == $type->id && $type->plans->first()->id == $plan->id && !old('plan_id') && !$preselectedPlanId);
                                                @endphp
                                                <option value="{{ $plan->id }}" {{ $isSelected ? 'selected' : '' }}>
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
                                    Date de Début <span class="text-red-500">*</span>
                                </label>
                                <input id="start_date"
                                       type="date"
                                       name="start_date"
                                       value="{{ old('start_date', date('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('members.index') }}"
                           class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 text-sm">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Créer et Abonner
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>