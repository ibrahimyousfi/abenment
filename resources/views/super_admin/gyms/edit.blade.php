<x-super-admin-layout>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Gym</h1>
                <p class="text-gray-500 mt-1">Update details for {{ $gym->name }}</p>
            </div>
            <a href="{{ route('super_admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8">
            <!-- Edit Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('super_admin.gyms.update', $gym) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-bold text-gray-900 flex items-center pb-2 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            Gym Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Gym Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $gym->name) }}" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="subscription_expires_at" class="block text-sm font-medium text-gray-700 mb-1">Subscription Expiry</label>
                                <input type="date" name="subscription_expires_at" id="subscription_expires_at" value="{{ old('subscription_expires_at', $gym->subscription_expires_at->format('Y-m-d')) }}" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" required>
                                @error('subscription_expires_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="is_active" id="is_active" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow">
                                    <option value="1" {{ $gym->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$gym->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end border-t border-gray-100">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Extend Subscription -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center pb-2 border-b border-gray-100 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        Extend Subscription
                    </h3>
                    
                    <form action="{{ route('super_admin.gyms.extend', $gym) }}" method="POST" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1 w-full">
                            <label for="months" class="block text-sm font-medium text-gray-700 mb-1">Duration (Months)</label>
                            <input type="number" name="months" id="months" min="1" max="24" value="12" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" required>
                        </div>
                        <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-green-200 hover:bg-green-700 transition-all flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Extend
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-super-admin-layout>