<x-gym-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paramètres de la Salle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('gym.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Gym Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom de la Salle</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $gym->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gym Logo -->
                        <div class="mb-4">
                            <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                            @if($gym->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $gym->logo) }}" alt="Logo actuel" class="h-20 w-auto object-contain">
                                </div>
                            @endif
                            <input type="file" name="logo" id="logo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept="image/*">
                            @error('logo')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Format accepté: JPEG, PNG, JPG, GIF. Max 2MB.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 border-t pt-4">
                        <h3 class="text-lg font-medium text-gray-900">Informations de Connexion</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Ces informations ne peuvent pas être modifiées ici. Veuillez contacter l'administrateur système pour toute demande de changement de compte.
                        </p>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input type="text" value="{{ auth()->user()->email }}" disabled class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
