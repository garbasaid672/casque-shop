{{-- Bouton de bascule mode sombre/clair. Le choix est mémorisé (localStorage)
     et s'applique automatiquement à toutes les pages du site. --}}
<button type="button" onclick="toggleTheme()" aria-label="Basculer entre le mode clair et sombre"
        class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-sky-100 dark:hover:bg-slate-800 hover:text-sky-600 dark:hover:text-sky-400 transition-colors">
    <!-- Icône lune (visible en mode clair) -->
    <svg data-theme-icon="moon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
    </svg>
    <!-- Icône soleil (visible en mode sombre) -->
    <svg data-theme-icon="sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
</button>
<script>
    function updateThemeIcons() {
        var isDark = document.documentElement.classList.contains('dark');
        document.querySelectorAll('[data-theme-icon="moon"]').forEach(function (el) { el.classList.toggle('hidden', isDark); });
        document.querySelectorAll('[data-theme-icon="sun"]').forEach(function (el) { el.classList.toggle('hidden', !isDark); });
    }
    function toggleTheme() {
        var isDark = document.documentElement.classList.toggle('dark');
        try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch (e) {}
        updateThemeIcons();
    }
    updateThemeIcons();
</script>
