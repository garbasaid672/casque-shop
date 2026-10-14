<div class="w-full max-w-md">
    <!-- Carte -->
    <div class="bg-white dark:bg-slate-900 border border-sky-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden">
        <!-- Bandeau supérieur -->
        <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-sky-900 px-8 py-8 text-center">
            <h1 class="text-2xl font-extrabold text-white">Bienvenue</h1>
            <p class="text-sky-200 text-sm mt-2">Connectez-vous pour accéder à votre compte</p>
        </div>

        <div class="px-8 py-8">
            {{ $this->form }}

            <!-- Lien inscription -->
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-sky-600 dark:text-sky-400 hover:underline font-semibold">Créer un compte</a>
            </p>
        </div>
    </div>

    <!-- Bouton retour à l'accueil -->
    <a href="{{ route('home') }}" class="mt-6 flex items-center justify-center gap-2 w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold py-2.5 rounded-lg hover:border-sky-500 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
        &larr; Retour à l'accueil
    </a>
</div>
