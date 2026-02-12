<x-gym-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full gap-4">
            <div class="flex items-center gap-2 hidden md:flex">
                <a href="{{ route('gym.training-types.index') }}" class="text-gray-400 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <h2 class="font-bold text-xl text-gray-900 leading-tight whitespace-nowrap">
                    {{ $trainingType->name }}
                </h2>
            </div>
            <div class="flex-1 w-full max-w-3xl">
                @include('layouts.topbar-actions', [
                    'searchPlaceholder' => 'Rechercher un plan...',
                    'addRoute' => 'gym.plans.create',
                    'addButtonLabel' => 'Ajouter Plan',
                    'addRouteParams' => ['training_type_id' => $trainingType->id]
                ])
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Info & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div class="pl-7">
                <p class="text-gray-500">{{ $trainingType->description ?? 'Aucune description fournie.' }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('gym.training-types.edit', $trainingType) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Modifier le type
                </a>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-1 h-6 bg-indigo-600 rounded-full"></span>
                Plans de tarification
            </h3>

            @if($trainingType->plans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($trainingType->plans as $plan)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow relative">
                            @if($plan->is_active)
                                <div class="absolute top-4 right-4 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white shadow-sm" title="Actif"></div>
                            @else
                                <div class="absolute top-4 right-4 w-3 h-3 bg-gray-300 rounded-full border-2 border-white shadow-sm" title="Inactif"></div>
                            @endif

                            <div class="p-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $plan->name }}</h4>
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-3xl font-bold text-indigo-600">{{ number_format($plan->price, 0) }}</span>
                                    <span class="text-sm text-gray-500">MAD</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-6 bg-gray-50 p-3 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Durée : <strong>{{ $plan->duration_days }} jours</strong></span>
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                                    <a href="{{ route('gym.plans.edit', $plan) }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Modifier</a>
                                    <form action="{{ route('gym.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                    <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-sm font-medium text-gray-900">Aucun plan défini</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-4">Commencez par ajouter un plan tarifaire pour ce type d'abonnement.</p>
                    <a href="{{ route('gym.plans.create', ['training_type_id' => $trainingType->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Ajouter un plan
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-gym-layout>
