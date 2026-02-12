<x-guest-layout>
    <div class="text-center">
        <div class="mb-6">
            <div class="mx-auto w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-4 border border-red-100">
                <svg class="h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-black text-gray-900 mb-2">Abonnement Expiré</h1>
            <p class="text-gray-500 mb-6 text-lg">
                Désolé, l'abonnement de votre salle de sport a expiré. Vous ne pouvez plus accéder au système tant que vous n'avez pas renouvelé votre abonnement.
            </p>

            <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-8 text-left">
                <p class="text-orange-600 text-sm font-bold flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><strong>Remarque :</strong> Vous avez été déconnecté automatiquement pour des raisons de sécurité. Vous pourrez vous reconnecter après le renouvellement.</span>
                </p>
            </div>

            <div class="flex flex-col space-y-4">
                <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold uppercase tracking-wider text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Retour à la connexion
                </a>

                <p class="text-xs text-gray-400">
                    Pour toute question, veuillez contacter le support technique.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
