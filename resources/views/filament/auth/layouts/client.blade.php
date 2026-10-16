<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ site_name() }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        // Thème initial : même clé que l'accueil (localStorage 'theme').
        (function () {
            try {
                var theme = localStorage.getItem('theme');
                var dark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.dataset.theme = dark ? 'dark' : 'light';
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>
    @filamentStyles
    {{-- Thème Filament (formulaire) : non inclus dans @filamentStyles, à charger explicitement --}}
    {{ filament()->getTheme()->getHtml() }}
    <style>
        /* ===== Base + entête + pied : identiques à la page d'accueil ===== */
        :root{--bg:#f1f4f9;--surface:#fff;--text:#0f172a;--muted:#5b6478;--line:#e3e8f0;--nav:rgba(255,255,255,.8);--yellow:#fbbf24;--blue:#0a84c6;--red:#e11d48;--navy:#050b24;--navy2:#0b4a6f;box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
        @media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#0b1020;--surface:#141b30;--text:#f1f5f9;--muted:#9aa5bd;--line:#252e48;--nav:rgba(11,16,32,.8);color-scheme:dark}}
        :root[data-theme="dark"]{--bg:#0b1020;--surface:#141b30;--text:#f1f5f9;--muted:#9aa5bd;--line:#252e48;--nav:rgba(11,16,32,.8);color-scheme:dark}
        *{box-sizing:border-box;margin:0}
        html{scroll-padding-top:env(safe-area-inset-top,0px);scroll-behavior:smooth}
        body{font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.5}
        body::before{content:"";position:fixed;inset:0 0 auto;height:env(safe-area-inset-top,0px);background:var(--nav);backdrop-filter:blur(10px);z-index:60}
        a{color:inherit;text-decoration:none}
        button{font:inherit;cursor:pointer}
        .wrap{max-width:1180px;margin:auto;padding:0 24px}
        header{position:sticky;top:env(safe-area-inset-top,0px);z-index:50;background:var(--nav);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
        .bar{display:flex;align-items:center;justify-content:space-between;height:68px;gap:16px}
        .logo{font-weight:800;font-size:24px;background:linear-gradient(90deg,#1d6fd6,#d99a1c);-webkit-background-clip:text;background-clip:text;color:transparent}
        nav{display:flex;gap:30px}
        nav a{position:relative;font-weight:500;color:var(--muted);padding:4px 0}
        nav a::after{content:"";position:absolute;left:0;bottom:-2px;height:2px;width:0;background:var(--yellow);transition:width .25s}
        nav a:hover,nav a.on{color:var(--text)}
        nav a:hover::after,nav a.on::after{width:100%}
        .tools{display:flex;align-items:center;gap:6px}
        .ic{width:40px;height:40px;border-radius:50%;border:0;background:transparent;color:var(--text);display:grid;place-items:center;position:relative}
        .ic:hover{background:var(--line)}
        .ic svg{width:20px;height:20px}
        .login{margin-left:6px;border:1.5px solid var(--text);background:transparent;color:var(--text);padding:8px 18px;border-radius:10px;font-weight:600;display:inline-block}
        .login:hover{background:var(--text);color:var(--bg)}
        .hello{font-size:14px;color:var(--muted);margin-right:4px}
        footer{margin-top:64px;background:var(--navy);color:#9fb0cf;padding:56px 0 28px;font-size:14px}
        .fg{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:32px}
        footer h4{color:#fff;margin-bottom:12px;font-size:15px}
        footer li{list-style:none;margin:8px 0}
        footer ul{padding:0}
        footer a:hover{color:var(--yellow)}
        .copy{margin-top:40px;padding-top:20px;border-top:1px solid rgba(255,255,255,.12);display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px}
        .copy a:hover{color:var(--yellow)}
        .news-mini{margin-top:12px}
        .news-mini p{font-size:13px;margin-bottom:8px}
        .news-mini form{display:flex;gap:8px}
        .news-mini input{flex:1;min-width:0;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.06);border-radius:10px;padding:10px 12px;font:inherit;color:#fff;font-size:13px}
        .news-mini input::placeholder{color:#7d8db1}
        .news-mini button{border:0;background:var(--yellow);color:#111;border-radius:10px;padding:0 16px;font-weight:700;font-size:13px}
        :focus-visible{outline:3px solid var(--blue);outline-offset:2px}
        @media (max-width:980px){.fg{grid-template-columns:1fr 1fr}nav{display:none}}
        @media (max-width:560px){.wrap{padding:0 18px}}
        @media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
        /* ===== Page de connexion : corps + carte ===== */
        body.auth-body{min-height:100vh;display:flex;flex-direction:column}
        main.auth-main{flex:1;display:flex;align-items:center;justify-content:center;padding:48px 18px}
        /* Champs identifiant / mot de passe : pleine largeur, hauteur réduite */
        .fi-input-wrp,
        .fi-fo-text-input,
        .fi-input {
            width: 100% !important;
        }
        .fi-input {
            min-height: 2.5rem !important;
            font-size: 1rem !important;
            padding: 0.5rem 0.9rem !important;
        }
        .fi-fo-field-label-content {
            font-size: 0.95rem !important;
        }
        .fi-ac-btn-action {
            min-height: 3rem !important;
            font-size: 1rem !important;
        }
        /* Bouton "Se connecter" : bleu clair */
        .fi-ac-btn-action {
            background-color: #7dd3fc !important;
            border-color: #7dd3fc !important;
            color: #0b2545 !important;
        }
        .fi-ac-btn-action:hover {
            background-color: #38bdf6 !important;
            border-color: #38bdf6 !important;
            color: #0b2545 !important;
        }
        /* Zone de connexion : carte blanche, texte sombre lisible en clair comme en sombre */
        .fi-simple-page {
            background: #ffffff !important;
            color: #0f172a !important;
            border-radius: 1.25rem !important;
            padding: 2rem !important;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.45) !important;
            width: 100% !important;
            max-width: 30rem !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        /* Conteneur : formulaire + encadré démo */
        .login-wrap {
            width: 100% !important;
            max-width: 30rem !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        /* Encadré des identifiants de démonstration (sans contour) */
        .demo-box {
            margin-top: 1rem !important;
            text-align: center !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border: 0 !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.9rem !important;
            line-height: 1.6 !important;
            color: #0f172a !important;
        }
        .demo-box code {
            background: #e2e8f0 !important;
            padding: 1px 6px !important;
            border-radius: 6px !important;
        }
        .fi-simple-page .fi-fo-field-label-content,
        .fi-simple-page label {
            color: #0f172a !important;
        }
        .fi-simple-page .fi-simple-header-heading {
            color: #0f172a !important;
        }
        /* Logo GMS Audio : même dégradé que l'entête + trait de séparation */
        .fi-simple-page .fi-logo {
            background: linear-gradient(to right, #0284c7, #2563eb, #f59e0b) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
            -webkit-text-fill-color: transparent !important;
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            padding-bottom: 1rem !important;
            border-bottom: 4px solid #e2e8f0 !important;
            margin-bottom: 1.5rem !important;
        }
        .fi-simple-page .fi-simple-header-subheading {
            color: #475569 !important;
        }
    </style>
</head>
<body class="auth-body" style="background: linear-gradient(rgba(2, 6, 23, 0.84), rgba(2, 6, 23, 0.72)), url('/storage/categories/cat-1.jpg') center / cover no-repeat fixed; background-color: #020617;">
    <!-- ========== HEADER (identique à l'accueil) ========== -->
    <header>
        <div class="wrap bar">
            <a href="{{ route('home') }}" class="logo">{{ site_name() }}</a>
            <nav aria-label="Navigation principale"><a class="on" href="{{ route('home') }}">Accueil</a><a href="{{ route('shop.index') }}">Boutique</a><a href="{{ route('categories.index') }}">Catégories</a></nav>
            <div class="tools">
                <a class="ic" href="{{ route('shop.index') }}" aria-label="Rechercher"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></a>
                <button class="ic" id="theme" aria-label="Changer de thème"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
                @auth
                <span class="hello">Bonjour, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="login">Déconnexion</button>
                </form>
                @else
                <a class="login" href="{{ route('filament.admin.auth.login') }}">Connexion</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ========== CONTENU (formulaire Livewire Filament) ========== -->
    <main class="auth-main">
        <div class="login-wrap">
            {{ $slot }}
            @include('filament.auth.login-demo')
        </div>
    </main>

    <!-- ========== FOOTER (identique à l'accueil) ========== -->
    <footer>
        <div class="wrap">
            <div class="fg">
                <div>
                    <div class="logo" style="font-size:22px;display:inline-block">{{ site_name() }}</div>
                    <p style="margin-top:10px;max-width:280px">Votre spécialiste casques audio de qualité.</p>
                    <div class="news-mini">
                        <p>Inscrivez-vous pour nos offres exclusives.</p>
                        <form><input type="email" placeholder="Votre email" aria-label="Votre email"><button>S'inscrire</button></form>
                    </div>
                </div>
                <div><h4>Liens rapides</h4><ul><li><a href="{{ route('home') }}">Accueil</a></li><li><a href="{{ route('shop.index') }}">Boutique</a></li><li><a href="{{ route('categories.index') }}">Catégories</a></li><li><a href="{{ route('contact') }}">Contact</a></li></ul></div>
                <div><h4>Support</h4><ul><li><a href="{{ route('support.faq') }}">FAQ</a></li><li><a href="{{ route('support.shipping') }}">Livraison</a></li><li><a href="{{ route('support.returns') }}">Retours</a></li><li><a href="{{ route('support.warranty') }}">Garantie</a></li></ul></div>
            </div>
            <div class="copy"><span>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés. · <a href="{{ route('filament.admin.auth.login') }}">Admin</a></span></div>
        </div>
    </footer>

    @livewire(Filament\Livewire\Notifications::class)
    @filamentScripts(withCore: true)
    <script>
        // Thème : même clé 'theme' que l'accueil (clair/sombre persisté partout).
        (function () {
            var root = document.documentElement;
            function apply(dark) {
                root.dataset.theme = dark ? 'dark' : 'light';
                root.classList.toggle('dark', dark);
                try { localStorage.setItem('theme', dark ? 'dark' : 'light'); } catch (e) {}
            }
            document.getElementById('theme').onclick = function () {
                apply(root.dataset.theme !== 'dark');
            };
        })();
    </script>
</body>
</html>
