<x-gym-layout>
    <div class="h-[calc(100vh-65px)] flex flex-col md:flex-row gap-6 p-4 overflow-hidden"
         x-data="posSystem()">

        <!-- Left Side: Products -->
        <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
            <!-- Search & Filter -->
            <div class="p-4 border-b border-gray-100 flex gap-4">
                <div class="relative flex-1">
                    <input type="text"
                           x-model="search"
                           placeholder="Rechercher un produit..."
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addToCart(product)"
                             class="bg-white rounded-xl border border-gray-200 p-3 cursor-pointer hover:border-indigo-500 hover:shadow-md transition-all flex flex-col h-full relative group">

                            <!-- Stock Badge -->
                            <div class="absolute top-2 right-2 z-10">
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full"
                                      :class="product.stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'">
                                    <span x-text="product.stock"></span>
                                </span>
                            </div>

                            <div class="aspect-w-1 aspect-h-1 mb-3 bg-gray-100 rounded-lg overflow-hidden h-32">
                                <img :src="product.image_path ? '{{ asset('storage') }}/' + product.image_path : 'https://placehold.co/100'"
                                     class="object-cover w-full h-full group-hover:scale-105 transition-transform"
                                     onerror="this.src='https://placehold.co/100?text=No+Image'">
                            </div>

                            <div class="mt-auto">
                                <h3 class="font-bold text-gray-900 text-sm truncate" x-text="product.name"></h3>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="font-bold text-indigo-600" x-text="formatMoney(product.price)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div x-show="filteredProducts.length === 0" class="text-center py-10 text-gray-500">
                    Aucun produit trouvé.
                </div>
            </div>
        </div>

        <!-- Right Side: Cart -->
        <div class="w-full md:w-96 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
            <div class="p-4 border-b border-gray-100 bg-indigo-50/50">
                <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Panier actuel
                </h2>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex gap-3 items-center bg-gray-50 p-2 rounded-lg border border-gray-100">
                        <div class="flex-1">
                            <h4 class="font-bold text-sm text-gray-900 truncate" x-text="item.name"></h4>
                            <div class="text-xs text-gray-500" x-text="formatMoney(item.price)"></div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button @click="updateQuantity(item.id, -1)" class="w-6 h-6 rounded bg-white border border-gray-300 flex items-center justify-center hover:bg-gray-100">-</button>
                            <span class="font-bold w-6 text-center text-sm" x-text="item.quantity"></span>
                            <button @click="updateQuantity(item.id, 1)" class="w-6 h-6 rounded bg-white border border-gray-300 flex items-center justify-center hover:bg-gray-100">+</button>
                        </div>

                        <div class="text-right min-w-[60px]">
                            <div class="font-bold text-sm text-indigo-600" x-text="formatMoney(item.price * item.quantity)"></div>
                            <button @click="removeFromCart(item.id)" class="text-xs text-red-500 hover:text-red-700 underline">Supprimer</button>
                        </div>
                    </div>
                </template>

                <div x-show="cart.length === 0" class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Le panier est vide
                </div>
            </div>

            <!-- Summary & Checkout -->
            <div class="p-4 border-t border-gray-100 bg-gray-50 space-y-4">
                <!-- Client -->
                <div>
                    <input type="text" x-model="clientName" placeholder="Nom du client (Optionnel)" class="w-full text-sm rounded-lg border-gray-300 py-1.5">
                </div>

                <!-- Payment Method -->
                <div class="grid grid-cols-3 gap-2">
                    <button @click="paymentMethod = 'cash'"
                            class="py-1.5 px-2 text-xs font-bold rounded-lg border transition-all"
                            :class="paymentMethod === 'cash' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300'">
                        Espèces
                    </button>
                    <button @click="paymentMethod = 'card'"
                            class="py-1.5 px-2 text-xs font-bold rounded-lg border transition-all"
                            :class="paymentMethod === 'card' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300'">
                        Carte
                    </button>
                    <button @click="paymentMethod = 'transfer'"
                            class="py-1.5 px-2 text-xs font-bold rounded-lg border transition-all"
                            :class="paymentMethod === 'transfer' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300'">
                        Virement
                    </button>
                </div>

                <!-- Totals -->
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Sous-total</span>
                        <span x-text="formatMoney(subtotal)"></span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Remise (MAD)</span>
                        <input type="number" x-model="discount" class="w-20 text-right py-0 px-1 text-sm border-gray-300 rounded" min="0">
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t border-gray-200 mt-2">
                        <span>Total</span>
                        <span x-text="formatMoney(total)"></span>
                    </div>
                </div>

                <!-- Pay Button -->
                <button @click="processPayment()"
                        :disabled="cart.length === 0 || processing"
                        class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex justify-center items-center gap-2">
                    <span x-show="!processing">Encaisser</span>
                    <span x-show="processing">Traitement...</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                products: @json($products),
                search: '',
                cart: [],
                clientName: '',
                paymentMethod: 'cash',
                discount: 0,
                processing: false,

                get filteredProducts() {
                    if (this.search === '') return this.products;
                    return this.products.filter(p => p.name.toLowerCase().includes(this.search.toLowerCase()));
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get total() {
                    return Math.max(0, this.subtotal - this.discount);
                },

                formatMoney(amount) {
                    return new Intl.NumberFormat('fr-MA', { style: 'currency', currency: 'MAD' }).format(amount);
                },

                addToCart(product) {
                    if (product.stock <= 0) return alert('Produit en rupture de stock');

                    let existingItem = this.cart.find(item => item.id === product.id);
                    if (existingItem) {
                        if (existingItem.quantity < product.stock) {
                            existingItem.quantity++;
                        } else {
                            alert('Stock insuffisant');
                        }
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            max_stock: product.stock
                        });
                    }
                },

                updateQuantity(id, change) {
                    let item = this.cart.find(i => i.id === id);
                    if (!item) return;

                    let newQty = item.quantity + change;
                    if (newQty > 0 && newQty <= item.max_stock) {
                        item.quantity = newQty;
                    } else if (newQty > item.max_stock) {
                        alert('Stock maximum atteint');
                    }
                },

                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                },

                processPayment() {
                    if (this.cart.length === 0) return;
                    if (!confirm('Confirmer le paiement de ' + this.formatMoney(this.total) + ' ?')) return;

                    this.processing = true;

                    fetch('{{ route("gym.pos.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            cart: this.cart,
                            client_name: this.clientName,
                            payment_method: this.paymentMethod,
                            discount: this.discount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.processing = false;
                        if (data.success) {
                            alert('Paiement réussi !');
                            window.location.reload(); // Reload to update stock
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    })
                    .catch(error => {
                        this.processing = false;
                        alert('Une erreur est survenue.');
                        console.error(error);
                    });
                }
            }
        }
    </script>
</x-gym-layout>
