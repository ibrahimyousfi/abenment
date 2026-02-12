<x-gym-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full gap-4">
            <h2 class="font-bold text-xl text-gray-900 leading-tight whitespace-nowrap hidden md:block">
                {{ __('Types d\'Abonnement') }}
            </h2>
            <div class="flex-1 w-full max-w-3xl">
                @include('layouts.topbar-actions', [
                    'searchPlaceholder' => 'Rechercher un type...',
                    'addRoute' => 'gym.training-types.create',
                    'addButtonLabel' => 'Nouveau Type'
                ])
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    @if($trainingTypes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($trainingTypes as $type)
                                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:border-indigo-500/30 hover:shadow-lg transition-all group relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>

                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-4">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $type->name }}</h3>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('gym.training-types.edit', $type) }}" class="text-gray-400 hover:text-indigo-600 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('gym.training-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <p class="text-gray-500 mb-6 text-sm line-clamp-2 h-10">{{ $type->description ?? 'Aucune description disponible.' }}</p>

                                        <div class="flex justify-between items-center text-sm pt-4 border-t border-gray-50">
                                            <span class="font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $type->plans_count }} Plans</span>
                                            <a href="{{ route('gym.training-types.show', $type) }}" class="text-indigo-600 hover:text-indigo-700 font-bold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                                Détails <span>&rarr;</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 mb-4 text-indigo-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Aucun type d'abonnement</h3>
                            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Commencez par créer des types d'abonnement (ex: Musculation, Cardio) pour y associer des plans tarifaires.</p>
                            <a href="{{ route('gym.training-types.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Ajouter le premier type
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
