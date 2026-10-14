<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - {{ site_name() }}</title>
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
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-sky-700 dark:text-sky-400">
                    {{ site_name() }}
                </a>
                <div class="flex items-center space-x-3">
                    @include('components.theme-toggle')
                    <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 font-medium text-sm">
                        &larr; Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== FORMULAIRE D'INSCRIPTION ========== -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-md">
            <!-- Carte -->
            <div class="bg-white dark:bg-slate-900 border border-sky-100 dark:border-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Bandeau supérieur -->
                <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-sky-900 px-8 py-8 text-center">
                    <h1 class="text-2xl font-extrabold text-white">Créer un compte</h1>
                    <p class="text-sky-200 text-sm mt-2">Rejoignez {{ site_name() }} en quelques secondes</p>
                </div>

                <div class="px-8 py-8">
                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg px-4 py-3 mb-6">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Nom complet
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Votre nom"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Adresse email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="vous@exemple.com"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Numéro de téléphone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Numéro de téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   placeholder="+228 90 00 00 00"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Adresse -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Adresse
                            </label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                   placeholder="Rue, avenue, repère..."
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Quartier -->
                        <div>
                            <label for="quartier" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Quartier
                            </label>
                            <input type="text" id="quartier" name="quartier" value="{{ old('quartier') }}" required
                                   placeholder="Votre quartier"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Mot de passe
                            </label>
                            <input type="password" id="password" name="password" required
                                   placeholder="8 caractères minimum"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   placeholder="Répétez le mot de passe"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Bouton -->
                        <button type="submit"
                                class="w-full bg-sky-600 text-white font-bold py-2.5 rounded-lg hover:bg-sky-700 transition-colors">
                            S'inscrire
                        </button>
                    </form>

                    <!-- Lien connexion -->
                    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="text-sky-600 dark:text-sky-400 hover:underline font-semibold">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.</p>
    </footer>
</body>
</html>
