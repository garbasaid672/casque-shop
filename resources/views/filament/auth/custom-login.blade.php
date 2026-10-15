<div class="w-full max-w-md">
    <!-- Carte -->
    <div class="bg-white dark:bg-slate-900 border border-sky-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden">
        <!-- Bandeau supérieur avec nom du site en couleur -->
        <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-sky-900 px-8 py-8 text-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 bg-clip-text text-transparent">
                {{ site_name() }}
            </a>
        </div>

        <div class="px-8 py-8">
            {{ $this->content }}

            <h1 class="text-2xl font-extrabold text-center text-slate-900 dark:text-slate-100 mt-6">Bienvenue</h1>

            @include('filament.auth.login-demo')

            
        </div>
    </div>

    <!-- Bouton retour à l'accueil -->
    <a href="{{ route('home') }}" class="mt-6 flex items-center justify-center gap-2 w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold py-2.5 rounded-lg hover:border-sky-500 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
        &larr; Retour à l'accueil
    </a>
</div>
