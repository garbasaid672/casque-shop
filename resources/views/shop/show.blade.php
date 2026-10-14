<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ site_name() }}</title>
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
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors font-medium">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Fil d'Ariane -->
            <nav class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-sky-600">Accueil</a>
                <span class="mx-2">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-sky-600">Boutique</a>
                @if($product->category)
                    <span class="mx-2">/</span>
                    <a href="{{ route('category.show', $product->category) }}" class="hover:text-sky-600">{{ $product->category->name }}</a>
                @endif
                <span class="mx-2">/</span>
                <span class="text-slate-800 dark:text-slate-200 font-medium">{{ $product->name }}</span>
            </nav>

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg px-4 py-3 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Fiche produit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-10">
                <!-- Photo -->
                <div class="relative aspect-square overflow-hidden rounded-xl bg-slate-200 dark:bg-slate-800">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}"
                             class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sky-100 to-blue-200 dark:from-slate-800 dark:to-blue-950">
                            <svg class="h-20 w-20 text-sky-500 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    @if($product->compare_at_price && $product->compare_at_price > $product->price)
                        <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1 text-sm font-bold text-slate-950 shadow">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                <!-- Infos + achat -->
                <div>
                    @if($product->category)
                        <a href="{{ route('category.show', $product->category) }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:underline">
                            {{ $product->category->name }}
                        </a>
                    @endif
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">{{ $product->name }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        {{ $product->brand }}@if($product->color) · {{ $product->color }}@endif · Réf : {{ $product->sku }}
                    </p>

                    <!-- Prix -->
                    <div class="flex items-center gap-3 mt-5">
                        <span class="text-3xl font-extrabold text-sky-700 dark:text-sky-400">{{ $product->price_fcfa }}</span>
                        @if($product->compare_at_price && $product->compare_at_price > $product->price)
                            <span class="text-lg text-slate-400 line-through">{{ $product->compare_at_price_fcfa }}</span>
                        @endif
                    </div>

                    <!-- Stock -->
                    <div class="mt-4">
                        @if($product->stock_quantity > 0)
                            <span class="inline-flex items-center gap-2 rounded-full bg-green-100 dark:bg-green-950 text-green-700 dark:text-green-300 px-3 py-1 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                En stock ({{ $product->stock_quantity }} disponible(s))
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300 px-3 py-1 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Rupture de stock
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($product->description)
                        <p class="text-slate-600 dark:text-slate-300 mt-5 leading-relaxed">{{ $product->description }}</p>
                    @endif

                    <!-- Caractéristiques -->
                    @if($product->features && count($product->features) > 0)
                        <ul class="mt-5 space-y-2">
                            @foreach($product->features as $feature)
                                <li class="flex items-start gap-2 text-sm text-slate-600 dark:text-slate-300">
                                    <svg class="w-5 h-5 text-sky-600 dark:text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if(Auth::check() && Auth::user()->is_admin)
                        <!-- Compte admin : achats désactivés -->
                        <div class="mt-8 bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 text-sm rounded-lg px-4 py-3">
                            Connecté en tant qu'administrateur : les achats sont désactivés sur ce compte.
                        </div>
                    @else
                    <!-- Quantité + bouton Payer -->
                    <form method="GET" action="{{ route('checkout.show', $product) }}" class="mt-8 flex flex-col sm:flex-row gap-3">
                        <div class="flex items-center border border-slate-300 dark:border-slate-700 rounded-lg overflow-hidden w-fit">
                            <label for="quantity" class="px-3 text-sm text-slate-500 dark:text-slate-400">Qté</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ max($product->stock_quantity, 1) }}"
                                   @if($product->stock_quantity < 1) disabled @endif
                                   class="w-16 px-2 py-2.5 text-center bg-transparent focus:outline-none">
                        </div>
                        <button type="submit" @if($product->stock_quantity < 1) disabled @endif
                                class="flex-1 bg-amber-400 text-slate-950 font-bold py-3 px-6 rounded-lg hover:bg-amber-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Payer maintenant
                        </button>
                    </form>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Paiement Mobile Money ou à la livraison · Livraison 1 500 FCFA</p>
                    @endif
                </div>
            </div>

            <!-- Produits similaires -->
            @if($related->isNotEmpty())
            <section class="mt-14">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Produits similaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $relatedProduct)
                        @include('components.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
            @endif
        </div>
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-slate-950 text-slate-300 py-12 mt-6">
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
