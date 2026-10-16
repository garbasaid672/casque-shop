<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Retours - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (remplace Vite en dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-sky-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 bg-clip-text text-transparent">
                        {{ site_name() }}
                    </a>
                </div>
                <!-- Navigation principale -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium">Accueil</a>
                    <a href="{{ route('shop.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium">Boutique</a>
                    <a href="{{ route('categories.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium">Catégories</a>
                </nav>
                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-4">
                    @include('components.theme-toggle')
                    @auth
                        <span class="text-slate-600 dark:text-slate-300 text-sm">Bonjour, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 text-sm font-medium">Déconnexion</button>
                        </form>
                    @else
                        <!-- Pas de lien connexion/inscription pour les clients -->
                        <span class="text-slate-600 dark:text-slate-300 text-sm">Visiteur</span>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- ========== EN-TÊTE ========== -->
        <section class="bg-gradient-to-br from-slate-950 via-blue-950 to-sky-900 text-white py-14">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl sm:text-4xl font-extrabold">Retours</h1>
                <p class="text-sky-100 mt-2">Satisfait ou remboursé sous 7 jours.</p>
            </div>
        </section>

        <!-- ========== CONTENU ========== -->
        <section class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-10 space-y-8">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Conditions de retour</h2>
                        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                            <li class="flex gap-2"><span class="text-sky-600 font-bold">•</span> Délai de <strong>7 jours</strong> après réception du colis.</li>
                            <li class="flex gap-2"><span class="text-sky-600 font-bold">•</span> Produit <strong>non utilisé</strong>, dans son emballage d'origine avec tous les accessoires.</li>
                            <li class="flex gap-2"><span class="text-sky-600 font-bold">•</span> Présentez votre <strong>numéro de commande</strong>.</li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Comment retourner un produit ?</h2>
                        <ol class="space-y-2 text-sm text-slate-600 dark:text-slate-300 list-decimal list-inside">
                            <li>Contactez-nous (téléphone, WhatsApp ou <a href="{{ route('contact') }}" class="text-sky-600 dark:text-sky-400 hover:underline">formulaire</a>) en précisant le motif.</li>
                            <li>Nous convenons ensemble de la reprise (retour livreur ou dépôt).</li>
                            <li>Après vérification, vous choisissez : <strong>échange</strong> ou <strong>remboursement via Mobile Money</strong> sous 48h.</li>
                        </ol>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Cas particuliers</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">Produit défectueux à la réception ? Il est repris sans condition et remplacé immédiatement : consultez aussi la page <a href="{{ route('support.warranty') }}" class="text-sky-600 dark:text-sky-400 hover:underline">Garantie</a>.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-slate-950 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Infos marque -->
                <div>
                    <h3 class="font-bold text-lg mb-4 bg-gradient-to-r from-sky-400 via-blue-400 to-amber-400 bg-clip-text text-transparent">{{ site_name() }}</h3>
                    <p class="text-sm text-slate-400">Votre spécialiste casques audio de qualité.</p>
                </div>
                <!-- Liens rapides -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400">Accueil</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-amber-400">Boutique</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-amber-400">Catégories</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-amber-400">Contact</a></li>
                    </ul>
                </div>
                <!-- Support -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('support.faq') }}" class="hover:text-amber-400">FAQ</a></li>
                        <li><a href="{{ route('support.shipping') }}" class="hover:text-amber-400">Livraison</a></li>
                        <li><a href="{{ route('support.returns') }}" class="hover:text-amber-400">Retours</a></li>
                        <li><a href="{{ route('support.warranty') }}" class="hover:text-amber-400">Garantie</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Newsletter</h4>
                    <p class="text-sm mb-4 text-slate-400">Inscrivez-vous pour nos offres exclusives.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Votre email" class="flex-1 bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <button class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-500 text-sm font-medium">S'inscrire</button>
                    </form>
                </div>
            </div>
<!-- Copyright -->
            <div class="border-t border-slate-800 mt-8 pt-8 text-center text-sm text-slate-500">
                <p>&copy; {{ date('Y' ) }} {{ site_name() }}. Tous droits réservés.</p>
            </div>

        </footer>
</body>
</html>
