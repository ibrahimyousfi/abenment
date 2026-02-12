<x-gym-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une Facture') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('gym.invoices.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Member -->
                            <div>
                                <label for="member_id" class="block text-sm font-medium text-gray-700">Client / Membre</label>
                                <select name="member_id" id="member_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Client Passager --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type de Facture</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="general">Général</option>
                                    <option value="subscription">Abonnement</option>
                                    <option value="product">Produit</option>
                                    <option value="service">Service</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Issue Date -->
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Date d'émission</label>
                                <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('issue_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700">Montant Total (MAD)</label>
                                <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('gym.invoices.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-500">Annuler</a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Créer la Facture
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-gym-layout>
