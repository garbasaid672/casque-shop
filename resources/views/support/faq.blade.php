<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQ - {{ site_name() }}</title>
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
                    <a href="{{ route('support.faq') }}" class="text-sky-600 dark:text-sky-400 font-semibold">FAQ</a>
                    <a href="{{ route('contact') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium">Contact</a>

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
                <h1 class="text-3xl sm:text-4xl font-extrabold">Questions fréquentes</h1>
                <p class="text-sky-100 mt-2">Tout ce qu'il faut savoir avant de commander.</p>
            </div>
        </section>

        <!-- ========== QUESTIONS / RÉPONSES ========== -->
        <section class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Comment passer une commande ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Choisissez votre casque, cliquez sur « Voir » puis « Payer maintenant », renseignez vos coordonnées et votre moyen de paiement. Vous recevez un numéro de commande et nous vous appelons pour confirmer la livraison.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Quels moyens de paiement acceptez-vous ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Nous acceptons le Mobile Money (T-Money, Flooz) et le paiement en espèces à la livraison.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Quels sont les délais et frais de livraison ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Comptez 24 à 48h sur Cotonou et 2 à 4 jours ouvrés dans le reste du Bénin. Les frais de livraison sont de 1 500 FCFA. Consultez la page <a href="{{ route('support.shipping') }}" class="text-sky-600 dark:text-sky-400 hover:underline">Livraison</a> pour le détail.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Puis-je retourner un produit ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Oui, sous 7 jours après réception si le produit n'a pas été utilisé. Voir la page <a href="{{ route('support.returns') }}" class="text-sky-600 dark:text-sky-400 hover:underline">Retours</a>.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Les produits sont-ils garantis ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Tous nos casques sont garantis 12 mois contre les défauts de fabrication. Détails sur la page <a href="{{ route('support.warranty') }}" class="text-sky-600 dark:text-sky-400 hover:underline">Garantie</a>.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Dois-je créer un compte pour commander ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Non, la commande est possible sans compte. Mais un compte permet de commander plus vite grâce aux coordonnées pré-remplies.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Comment suivre ma commande ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Gardez votre numéro de commande (ex : CMD-20261012-XXXXXX) et contactez-nous par téléphone ou WhatsApp pour connaître son état.</p>
                </details>
                <details class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-6 py-4 group">
                    <summary class="font-semibold cursor-pointer list-none flex justify-between items-center">
                        Un produit est en rupture, quand sera-t-il disponible ?
                        <span class="text-sky-600 group-open:rotate-45 transition-transform text-xl leading-none">+</span>
                    </summary>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed">Écrivez-nous via la page <a href="{{ route('contact') }}" class="text-sky-600 dark:text-sky-400 hover:underline">Contact</a> en précisant le produit : nous vous préviendrons dès son retour en stock.</p>
                </details>

                <p class="text-center text-sm text-slate-500 dark:text-slate-400 pt-4">
                    Une autre question ? <a href="{{ route('contact') }}" class="text-sky-600 dark:text-sky-400 hover:underline font-semibold">Contactez-nous</a>
                </p>
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
        </div>
    </footer>
</body>
</html>
