<x-gym-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planifier une Séance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('gym.sessions.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Séance</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Ex: Yoga Matinal" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Training Type -->
                            <div>
                                <label for="training_type_id" class="block text-sm font-medium text-gray-700">Discipline</label>
                                <select name="training_type_id" id="training_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($trainingTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('training_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('training_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Trainer -->
                            <div>
                                <label for="trainer_id" class="block text-sm font-medium text-gray-700">Entraîneur (Optionnel)</label>
                                <select name="trainer_id" id="trainer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Aucun / À déterminer</option>
                                    @foreach($trainers as $trainer)
                                        <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('trainer_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Début</label>
                                <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Fin</label>
                                <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité Max</label>
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 20) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('capacity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('gym.sessions.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-500">Annuler</a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Planifier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
