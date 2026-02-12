<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center no-print">
            <h1 class="text-2xl font-bold text-gray-900">Détails du Membre</h1>
            <a href="{{ route('members.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Retour à la liste
            </a>
        </div>

        @if(request()->has('print'))
        <style>
            @media print {
                nav, header, footer, .no-print { display: none !important; }
                .py-8 { padding: 0 !important; }
                .max-w-5xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
                .shadow-sm { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
                body { background: white !important; }
                .bg-gray-50 { background: white !important; }
            }
        </style>
        <script>
            window.onload = function() { window.print(); }
        </script>
        @endif

        <!-- Member Profile Card -->
        <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Photo -->
                    <div class="flex-shrink-0 flex justify-center md:justify-start">
                        @if($member->photo_path)
                            <img src="{{ asset('uploads/' . $member->photo_path) }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-indigo-50 shadow-md" 
                                 alt="{{ $member->full_name }}">
                        @else
                            <div class="w-32 h-32 rounded-full bg-indigo-50 flex items-center justify-center border-4 border-white shadow-md">
                                <span class="text-indigo-600 font-bold text-4xl">
                                    {{ substr($member->full_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row justify-between items-center md:items-start mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $member->full_name }}</h2>
                                <p class="text-sm text-gray-500 font-mono mt-1">{{ $member->cin }}</p>
                            </div>
                            
                            @php $status = $member->status; @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-bold rounded-full mt-2 md:mt-0
                                {{ $status == 'Active' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                                {{ $status == 'Expired' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}
                                {{ $status == 'Inactive' ? 'bg-gray-100 text-gray-600 border border-gray-200' : '' }}
                            ">
                                {{ $status == 'Active' ? 'ACTIF' : ($status == 'Expired' ? 'EXPIRÉ' : 'INACTIF') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6 border-t border-gray-50 pt-6">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Téléphone</p>
                                <p class="font-medium text-gray-900 mt-1">{{ $member->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Genre</p>
                                <p class="font-medium text-gray-900 mt-1 capitalize">{{ $member->gender == 'male' ? 'Homme' : 'Femme' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Membre depuis le</p>
                                <p class="font-medium text-gray-900 mt-1">{{ $member->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap justify-end gap-3 no-print">
                    @if($member->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                    <a href="{{ route('members.edit', $member) }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium shadow-sm">
                        Modifier
                    </a>
                    <a href="{{ route('members.renew', $member) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow-sm">
                        Renouveler l'abonnement
                    </a>
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm font-medium shadow-sm">
                        Imprimer Carte
                    </button>
                </div>
            </div>
        </div>

        <!-- Subscription History -->
        <div class="bg-white border border-gray-100 overflow-hidden shadow-sm sm:rounded-2xl no-print">
            <div class="p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-indigo-600 rounded-full"></span>
                    Historique des abonnements
                </h3>
                
                @if($member->subscriptions->isNotEmpty())
                <div class="overflow-x-auto rounded-lg border border-gray-100">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Plan</th>
                                <th class="px-6 py-3">Discipline</th>
                                <th class="px-6 py-3">Durée</th>
                                <th class="px-6 py-3">Début</th>
                                <th class="px-6 py-3">Fin</th>
                                <th class="px-6 py-3">Prix</th>
                                <th class="px-6 py-3">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($member->subscriptions->sortByDesc('created_at') as $subscription)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $subscription->plan->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $subscription->plan->trainingType->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $subscription->plan->duration_days }} jours</td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $subscription->start_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $subscription->end_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ number_format($subscription->price_snapshot, 2) }} MAD</td>
                                <td class="px-6 py-4">
                                    @if($subscription->end_date >= now()->toDateString())
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">Actif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600">Expiré</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    Aucun historique d'abonnement disponible.
                </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>