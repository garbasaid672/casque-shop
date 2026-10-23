<style>
    .site-header{position:sticky;top:0;z-index:1000;width:100%;background:rgba(255,255,255,.9);backdrop-filter:blur(12px);border-bottom:1px solid #e3e8f0}
    .dark .site-header{background:rgba(11,16,32,.9);border-color:#252e48}
    .site-header-inner{position:relative;display:flex;align-items:center;justify-content:space-between;gap:16px;width:100%;max-width:1180px;height:55px;margin:auto;padding:0 24px}
    .site-header-logo{flex:none;font-size:24px;font-weight:800;background:linear-gradient(90deg,#1d6fd6,#d99a1c);-webkit-background-clip:text;background-clip:text;color:transparent;text-decoration:none}
    .site-header-nav{display:flex;align-items:center;gap:30px}
    .site-header-nav a{position:relative;padding:4px 0;color:#5b6478;font-weight:500;text-decoration:none}
    .dark .site-header-nav a{color:#9aa5bd}
    .site-header-nav a:hover,.site-header-nav a.is-active{color:#0f172a}
    .dark .site-header-nav a:hover,.dark .site-header-nav a.is-active{color:#f1f5f9}
    .site-header-nav a::after{position:absolute;right:0;bottom:-2px;left:0;height:2px;background:#fbbf24;content:"";transform:scaleX(0);transform-origin:left;transition:transform .25s}
    .site-header-nav a:hover::after,.site-header-nav a.is-active::after{transform:scaleX(1)}
    .site-header-mobile-item,.site-header-mobile-logout-form{display:none}
    .site-header-actions{display:flex;align-items:center;gap:6px}
    .site-header-icon,.site-header-menu-toggle{display:grid;width:40px;height:40px;place-items:center;border:0;border-radius:50%;background:transparent;color:#0f172a;text-decoration:none}
    .dark .site-header-icon,.dark .site-header-menu-toggle{color:#f1f5f9}
    .site-header-icon:hover,.site-header-menu-toggle:hover{background:#e3e8f0}
    .dark .site-header-icon:hover,.dark .site-header-menu-toggle:hover{background:#252e48}
    .site-header-icon svg,.site-header-menu-toggle svg{display:block;width:20px;height:20px;flex:none}
    .site-header-menu-toggle{display:none;padding:0!important;appearance:none;line-height:1}
    .site-header-login{display:inline-block;margin-left:6px;padding:8px 18px;border:1.5px solid #0f172a;border-radius:10px;background:transparent;color:#0f172a;font-weight:600;text-decoration:none}
    .dark .site-header-login{border-color:#f1f5f9;color:#f1f5f9}
    .site-header-login:hover{background:#0f172a;color:#fff}
    .dark .site-header-login:hover{background:#f1f5f9;color:#0f172a}
    .site-header-greeting{color:#5b6478;font-size:14px}
    .dark .site-header-greeting{color:#9aa5bd}
    .site-header-theme{display:grid;width:40px;height:40px;place-items:center;border:0;border-radius:50%;background:transparent;color:inherit}
    .site-header-nav>.site-header-theme{display:none}
    .site-header-theme:hover{background:#e3e8f0}
    .dark .site-header-theme:hover{background:#252e48}
    .site-header-theme svg{width:20px;height:20px}
    @media(max-width:980px){
        .site-header-inner{gap:8px;padding:0 24px}
        .site-header-nav{display:none;position:absolute;top:100%;right:18px;left:18px;z-index:1001;align-items:stretch;flex-direction:column;gap:0;padding:10px;border:1px solid #e3e8f0;border-radius:14px;background:#fff;box-shadow:0 16px 36px rgba(15,23,42,.18)}
        .dark .site-header-nav{border-color:#252e48;background:#141b30}
        .site-header-nav.is-open{display:flex}
        .site-header-nav a{padding:12px 14px;border-radius:9px}
        .site-header-nav a:hover{background:#f1f4f9}
        .dark .site-header-nav a:hover{background:#0b1020}
        .site-header-nav a::after{display:none}
        .site-header-mobile-item{display:block}
        .site-header-mobile-login{width:fit-content;margin:6px 14px;padding:8px 18px;border:1.5px solid #0f172a;border-radius:10px}
        .dark .site-header-mobile-login{border-color:#f1f5f9}
        .site-header-mobile-logout-form{display:block}
        .site-header-mobile-logout{display:block;width:100%;padding:12px 14px;border:0;border-radius:9px;background:transparent;color:#5b6478;font:inherit;text-align:left}
        .dark .site-header-mobile-logout{color:#9aa5bd}
        .site-header-mobile-logout:hover{background:#f1f4f9}
        .dark .site-header-mobile-logout:hover{background:#0b1020}
        .site-header-actions>.site-header-icon,.site-header-actions>.site-header-theme,.site-header-actions>.site-header-login,.site-header-actions>.site-header-greeting,.site-header-actions>form{display:none}
        .site-header-menu-toggle{display:grid;width:40px;height:40px;border:1px solid #e3e8f0;border-radius:12px}
        .dark .site-header-menu-toggle{border-color:#252e48}
        .site-header-nav>.site-header-theme{display:flex;width:100%;height:auto;justify-content:flex-start;gap:10px;padding:12px 14px;border-radius:9px;font-weight:600;text-align:left}
        .site-header-theme:hover{background:#f1f4f9}
        .dark .site-header-theme:hover{background:#0b1020}
    }
    @media(max-width:560px){
        .site-header-inner{gap:6px;padding:0 18px}
        .site-header-logo{font-size:19px}
        .site-header-actions{gap:2px}
        .site-header-menu-toggle{width:36px;height:36px;flex:none}
        .site-header-nav{right:18px;left:18px}
    }
</style>

<header class="site-header">
    <div class="site-header-inner">
        <a href="{{ route('home') }}" class="site-header-logo">{{ site_name() }}</a>
        <nav class="site-header-nav" id="site-header-nav" aria-label="Navigation principale">
            <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Accueil</a>
            <a href="{{ route('shop.index') }}" @class(['is-active' => request()->routeIs('shop.index')])>Boutique</a>
            <a href="{{ route('categories.index') }}" @class(['is-active' => request()->routeIs('categories.*')])>Catégories</a>
            <a href="{{ route('support.faq') }}" @class(['is-active' => request()->routeIs('support.faq')])>FAQ</a>
            <a href="{{ route('contact') }}" @class(['is-active' => request()->routeIs('contact')])>Contact</a>
            <a class="site-header-mobile-item" href="{{ route('shop.index') }}">Recherche</a>
            @auth
                <form class="site-header-mobile-logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="site-header-mobile-logout">Déconnexion</button>
                </form>
            @else
                <a class="site-header-mobile-item site-header-mobile-login" href="{{ route('filament.admin.auth.login') }}">Connexion</a>
            @endauth
            <button class="site-header-theme" type="button" data-site-header-theme aria-label="Changer de thème">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
                <span>Changer de thème</span>
            </button>
        </nav>
        <div class="site-header-actions">
            <button class="site-header-menu-toggle" type="button" aria-label="Ouvrir le menu" aria-controls="site-header-nav" aria-expanded="false" data-site-header-menu>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a class="site-header-icon" href="{{ route('shop.index') }}" aria-label="Rechercher">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </a>
            <button class="site-header-theme" type="button" data-site-header-theme aria-label="Changer de thème">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
            </button>
            @auth
                <span class="site-header-greeting">Bonjour, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="site-header-login">Déconnexion</button>
                </form>
            @else
                <a class="site-header-login" href="{{ route('filament.admin.auth.login') }}">Connexion</a>
            @endauth
        </div>
    </div>
</header>

<script>
    (function () {
        var nav = document.getElementById('site-header-nav');
        var toggle = document.querySelector('[data-site-header-menu]');
        if (!nav || !toggle) return;

        function closeMenu() {
            nav.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Ouvrir le menu');
        }

        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
        });
        nav.addEventListener('click', function (event) {
            if (event.target.closest('a')) closeMenu();
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeMenu();
        });
        document.querySelectorAll('[data-site-header-theme]').forEach(function (button) {
            button.addEventListener('click', function () {
                var root = document.documentElement;
                var dark = !root.classList.contains('dark');
                root.classList.toggle('dark', dark);
                root.dataset.theme = dark ? 'dark' : 'light';
                try { localStorage.setItem('theme', dark ? 'dark' : 'light'); } catch (error) {}
                closeMenu();
            });
        });
    })();
</script>
