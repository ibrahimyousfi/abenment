<x-gym-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier le plan d'abonnement</h1>
                <p class="text-gray-500 text-sm mt-1">Modifier les détails du plan : {{ $plan->name }}</p>
            </div>
            <a href="{{ route('gym.training-types.show', $plan->training_type_id) }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-8">
                <form method="POST" action="{{ route('gym.plans.update', $plan) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom du plan</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm bg-gray-50" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Duration -->
                        <div class="mb-6">
                            <label for="duration_days" class="block text-sm font-bold text-gray-700 mb-2">Durée (en jours)</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" min="1" class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Jours</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Prix (MAD)</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" step="0.01" min="0" class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50" required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">MAD</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="is_active" class="block text-sm font-bold text-gray-700 mb-2">Statut</label>
                        <select name="is_active" id="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm bg-gray-50">
                            <option value="1" {{ $plan->is_active ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ !$plan->is_active ? 'selected' : '' }}>Inactif</option>
                        </select>
                        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 gap-4">
                        <a href="{{ route('gym.training-types.show', $plan->training_type_id) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Annuler</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-gym-layout>
