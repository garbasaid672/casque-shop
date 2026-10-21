<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catégories - {{ site_name() }}</title>
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
    @include('components.site-header')

    <main>
        <!-- ========== EN-TÊTE ========== -->
        <section class="bg-gradient-to-br from-slate-950 via-blue-950 to-sky-900 text-white py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl sm:text-4xl font-extrabold">Toutes nos catégories</h1>
                <p class="text-sky-100 mt-2">Explorez chaque univers et trouvez le casque fait pour vous.</p>
            </div>
        </section>

        <!-- ========== GRILLE CATÉGORIES ========== -->
        <section class="py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($categories->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-slate-500 dark:text-slate-400">Aucune catégorie pour le moment.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($categories as $category)
                            @include('components.category-card', ['category' => $category])
                        @endforeach
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
