<x-super-admin-layout>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add New Gym</h1>
                <p class="text-gray-500 mt-1">Create a new gym workspace and assign an administrator.</p>
            </div>
            <a href="{{ route('super_admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('super_admin.gyms.store') }}" class="space-y-6">
                    @csrf

                    <!-- Gym Details Section -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center pb-2 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            Gym Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="gym_name" class="block text-sm font-medium text-gray-700 mb-1">Gym Name</label>
                                <input type="text" name="gym_name" id="gym_name" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" placeholder="e.g. Iron Paradise Gym" required>
                                <x-input-error :messages="$errors->get('gym_name')" class="mt-2" />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="subscription_months" class="block text-sm font-medium text-gray-700 mb-1">Subscription Plan</label>
                                <select name="subscription_months" id="subscription_months" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow">
                                    <option value="1">1 Month Trial</option>
                                    <option value="6">6 Months</option>
                                    <option value="12" selected>1 Year (Annual)</option>
                                    <option value="24">2 Years</option>
                                </select>
                                <x-input-error :messages="$errors->get('subscription_months')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Admin Details Section -->
                    <div class="space-y-6 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center pb-2 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            Gym Administrator
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="admin_name" id="admin_name" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" placeholder="e.g. John Doe" required>
                                <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="admin_email" id="admin_email" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" placeholder="john@example.com" required>
                                <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" name="admin_password" id="admin_password" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" required>
                                <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="admin_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex items-center justify-end gap-4 border-t border-gray-100">
                        <a href="{{ route('super_admin.dashboard') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Create Gym
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-super-admin-layout>