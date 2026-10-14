{{-- Carte produit réutilisable (accueil + page catégorie).
     Variables : $product (modèle Produit), $badge ('nouveau' ou null). --}}
<article class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden hover:shadow-xl hover:border-sky-300 dark:hover:border-sky-700 transition-shadow">
    <!-- Image du produit : ratio 4/3 + zoom Tailwind au survol -->
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-200 dark:bg-slate-800">
        @if($product->images && count($product->images) > 0)
            <img src="{{ product_image_url($product->images[0]) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sky-100 to-blue-200 dark:from-slate-800 dark:to-blue-950">
                <svg class="h-12 w-12 text-sky-500 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        <!-- Badge promo (prioritaire) ou badge nouveauté -->
        @if($product->compare_at_price && $product->compare_at_price > $product->price)
            <span class="absolute left-3 top-3 rounded-full bg-amber-400 px-2.5 py-1 text-xs font-bold text-slate-950 shadow">
                -{{ $product->discount_percentage }}%
            </span>
        @elseif(($badge ?? null) === 'nouveau')
            <span class="absolute left-3 top-3 rounded-full bg-sky-600 px-2.5 py-1 text-xs font-bold text-white shadow">
                Nouveau
            </span>
        @endif
    </div>
    <!-- Infos produit -->
    <div class="p-5">
        <h3 class="font-semibold text-slate-900 dark:text-white mb-1 line-clamp-1">
            {{ $product->name }}
        </h3>
        @if($product->category)
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">{{ $product->category->name }}</p>
        @endif
        <!-- Prix et réduction -->
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xl font-bold text-sky-700 dark:text-sky-400">
                    {{ $product->price_fcfa }}
                </span>
                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                    <span class="text-sm text-slate-400 line-through ml-2">
                        {{ $product->compare_at_price_fcfa }}
                    </span>
                    <span class="text-sm text-amber-600 dark:text-amber-400 ml-2 font-medium">
                        -{{ $product->discount_percentage }}%
                    </span>
                @endif
            </div>
            <a href="{{ route('product.show', $product) }}" class="text-sky-600 dark:text-sky-400 hover:underline text-sm font-medium">
                Voir
            </a>
        </div>
    </div>
</article>
