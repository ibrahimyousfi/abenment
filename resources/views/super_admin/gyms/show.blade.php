<x-super-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $gym->name }}</h1>
                <p class="text-gray-500 mt-1">Gym ID: #{{ $gym->id }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('super_admin.gyms.edit', $gym) }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl font-semibold shadow-sm hover:bg-gray-50 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Edit Gym
                </a>
                <form action="{{ route('super_admin.gyms.toggle', $gym) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="{{ $gym->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} px-4 py-2 rounded-xl font-semibold transition-all flex items-center">
                        @if($gym->is_active)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Deactivate
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Activate
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Status Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    @if($gym->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Active</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Inactive</span>
                    @endif
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase">Subscription Status</h3>
                <p class="text-lg font-bold text-gray-900 mt-1">
                    @if($gym->isSubscriptionExpired())
                        <span class="text-red-500">Expired</span>
                    @else
                        {{ $gym->getDaysUntilExpiry() }} days remaining
                    @endif
                </p>
                <p class="text-xs text-gray-400 mt-1">Expires on {{ $gym->subscription_expires_at->format('d M, Y') }}</p>
            </div>

            <!-- Members Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase">Total Members</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($gym->members->count()) }}</p>
                <p class="text-xs text-gray-400 mt-1">Registered members</p>
            </div>

            <!-- Revenue Card (Mock) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase">Total Subscriptions</h3>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($gym->subscriptions->count()) }}</p>
                <p class="text-xs text-gray-400 mt-1">Active subscriptions</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Staff List -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Gym Administrators & Staff</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($gym->users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('d M, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">No users found for this gym.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Recent Member Subscriptions</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Member</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Plan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($gym->subscriptions->take(5) as $sub)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $sub->member->full_name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $sub->plan->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($sub->end_date >= now())
                                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Active</span>
                                    @else
                                        <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Expired</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">No subscriptions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-super-admin-layout>
