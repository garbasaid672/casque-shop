<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boutique - {{ site_name() }}</title>
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
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold text-sky-700 dark:text-sky-400">
                        {{ site_name() }}
                    </a>
                </div>
                <!-- Navigation principale -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 dark:hover:text-sky-400 font-medium">Accueil</a>
                    <a href="{{ route('shop.index') }}" class="text-sky-600 dark:text-sky-400 font-semibold">Boutique</a>
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
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors font-medium">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- ========== EN-TÊTE ========== -->
        <section class="bg-gradient-to-br from-slate-950 via-blue-950 to-sky-900 text-white py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl sm:text-4xl font-extrabold">La boutique</h1>
                <p class="text-sky-100 mt-2">Tous nos casques audio, au meilleur prix.</p>
                <!-- Barre de recherche -->
                <form method="GET" action="{{ route('shop.index') }}" class="mt-6 flex flex-col sm:flex-row gap-3 max-w-2xl">
                    <input type="hidden" name="categorie" value="{{ request('categorie') }}">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un casque, une marque..."
                           class="flex-1 bg-white/10 border border-white/20 rounded-lg px-4 py-2.5 text-sm text-white placeholder-sky-300 focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <button class="bg-amber-400 text-slate-950 px-6 py-2.5 rounded-lg font-bold hover:bg-amber-300 text-sm">Rechercher</button>
                </form>
            </div>
        </section>

        <!-- ========== FILTRES ========== -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center gap-4 justify-between">
                    <!-- Filtres catégories -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('shop.index', array_filter(['q' => request('q'), 'tri' => request('tri')])) }}"
                           class="px-4 py-1.5 rounded-full text-sm font-medium {{ ! $currentCategory ? 'bg-sky-600 text-white' : 'bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-sky-500' }}">
                            Tous
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('shop.index', array_filter(['q' => request('q'), 'tri' => request('tri'), 'categorie' => $cat->slug])) }}"
                               class="px-4 py-1.5 rounded-full text-sm font-medium {{ $currentCategory && $currentCategory->id === $cat->id ? 'bg-sky-600 text-white' : 'bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-sky-500' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                    <!-- Tri -->
                    <form method="GET" action="{{ route('shop.index') }}">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <input type="hidden" name="categorie" value="{{ request('categorie') }}">
                        <select name="tri" onchange="this.form.submit()"
                                class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Trier : Nouveautés</option>
                            <option value="prix-asc" {{ request('tri') === 'prix-asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="prix-desc" {{ request('tri') === 'prix-desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="nom" {{ request('tri') === 'nom' ? 'selected' : '' }}>Nom A-Z</option>
                        </select>
                    </form>
                </div>

                <!-- Résultats -->
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-6 mb-4">{{ $products->total() }} produit(s) trouvé(s)</p>

                @if($products->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-slate-500 dark:text-slate-400">Aucun produit ne correspond à votre recherche.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-sky-600 text-white px-6 py-2.5 rounded-lg hover:bg-sky-700 font-medium text-sm">Voir tout le catalogue</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-slate-950 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Infos marque -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">{{ site_name() }}</h3>
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
