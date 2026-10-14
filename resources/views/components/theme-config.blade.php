{{-- Configuration du mode sombre/clair : à inclure juste après le CDN Tailwind.
     Active le dark mode par classe et applique le thème sauvegardé (ou celui du système). --}}
<script>
    tailwind.config = { darkMode: 'class' };
    (function () {
        try {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (e) {}
    })();
</script>
