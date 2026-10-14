{{-- Carte catégorie réutilisable (accueil + page catégories). Variable : $category. --}}
<a href="{{ route('category.show', $category) }}" class="group bg-white dark:bg-slate-800 border border-sky-100 dark:border-slate-700 rounded-xl overflow-hidden text-center hover:shadow-xl hover:border-sky-300 dark:hover:border-sky-600 transition-shadow">
    @if($category->image)
        <div class="h-32 overflow-hidden">
            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
        </div>
    @else
        <!-- Icône par défaut si pas d'image -->
        <div class="h-32 bg-sky-100 dark:bg-sky-950 flex items-center justify-center">
            <svg class="w-10 h-10 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    @endif
    <div class="p-4">
        <h3 class="font-semibold text-slate-900 dark:text-white">{{ $category->name }}</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $category->products_count }} produit(s)</p>
    </div>
</a>
