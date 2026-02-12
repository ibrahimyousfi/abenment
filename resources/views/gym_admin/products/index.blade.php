<x-gym-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full gap-4">
            <h2 class="font-bold text-xl text-gray-900 leading-tight whitespace-nowrap hidden md:block">
                {{ __('Gestion des Produits') }}
            </h2>
            <div class="flex-1 w-full max-w-3xl">
                @include('layouts.topbar-actions', [
                    'searchPlaceholder' => 'Rechercher un produit...',
                    'addRoute' => 'gym.products.create',
                    'addButtonLabel' => 'Ajouter Produit'
                ])
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="p-8 text-gray-900">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg transition-all group relative">
                                    <!-- Image -->
                                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 relative overflow-hidden h-48">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                                                 onerror="this.src='https://placehold.co/400x300?text=No+Image'">
                                        @else
                                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif

                                        <!-- Stock Badge -->
                                        <div class="absolute top-2 right-2">
                                            @if($product->stock > 0)
                                                <span class="px-2 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-lg shadow-sm">
                                                    Stock: {{ $product->stock }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-lg shadow-sm">
                                                    Rupture de stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-gray-900 truncate pr-2" title="{{ $product->name }}">{{ $product->name }}</h3>
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('gym.products.edit', $product) }}" class="text-gray-400 hover:text-indigo-600 transition p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                <form action="{{ route('gym.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="flex items-baseline gap-1 mt-2">
                                            <span class="text-2xl font-bold text-indigo-600">{{ number_format($product->price, 0) }}</span>
                                            <span class="text-xs text-gray-500 font-medium">MAD</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 mb-4 text-indigo-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Aucun produit</h3>
                            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Ajoutez des produits (protéines, boissons, équipements) pour les vendre à vos membres.</p>
                            <a href="{{ route('gym.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Ajouter le premier produit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
