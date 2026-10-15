<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (remplace Vite en dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-sky-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 bg-clip-text text-transparent">
                    {{ site_name() }}
                </a>
                <div class="flex items-center space-x-3">
                    @include('components.theme-toggle')
                    <a href="{{ route('home') }}" class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 font-semibold text-sm transition-colors">
                        &larr; Accueil
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== FORMULAIRE DE CONNEXION ========== -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-md">
            <!-- Carte -->
            <div class="bg-white dark:bg-slate-900 border border-sky-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Bandeau supérieur -->
                <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-sky-900 px-8 py-8 text-center">
                    <h1 class="text-2xl font-extrabold text-white">Bienvenue</h1>
                    <p class="text-sky-200 text-sm mt-2">Connectez-vous pour accéder à votre compte</p>
                </div>

                <div class="px-8 py-8">
                    <!-- Message d'erreur global -->
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg px-4 py-3 mb-6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Adresse email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="vous@exemple.com"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-sky-500 rounded-lg px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Mot de passe
                            </label>
                            <input type="password" id="password" name="password" required
                                   placeholder="Votre mot de passe"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-sky-500 rounded-lg px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Se souvenir + mot de passe oublié -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                Se souvenir de moi
                            </label>
                            <a href="#" class="text-sky-600 dark:text-sky-400 hover:underline font-medium">Mot de passe oublié ?</a>
                        </div>

                        <!-- Bouton -->
                        <button type="submit"
                                class="w-full bg-sky-600 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-sky-700 transition-colors">
                            Se connecter
                        </button>
                    </form>

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
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} Tous droits réservés.</p>
    </footer>
</body>
</html>
