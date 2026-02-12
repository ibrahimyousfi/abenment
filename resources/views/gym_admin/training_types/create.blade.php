<x-gym-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ajouter un type d'abonnement</h1>
                <p class="text-gray-500 text-sm mt-1">Créez une nouvelle catégorie pour vos services (ex: Musculation, Yoga).</p>
            </div>
            <a href="{{ route('gym.training-types.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-8">
                <form method="POST" action="{{ route('gym.training-types.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nom du type</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm bg-gray-50" placeholder="Ex: Musculation, Cardio, Boxe..." required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description (Optionnel)</label>
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm bg-gray-50" placeholder="Brève description de ce type d'activité...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 gap-4">
                        <a href="{{ route('gym.training-types.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Annuler</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-gym-layout>
