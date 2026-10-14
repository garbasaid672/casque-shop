<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (même habillage que la page client) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    @filamentStyles
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Champs identifiant / mot de passe bien visibles */
        .fi-input {
            min-height: 3rem !important;
            font-size: 1rem !important;
            padding: 0.75rem 1rem !important;
        }
        .fi-fo-field-label-content {
            font-size: 0.95rem !important;
        }
        .fi-ac-btn-action {
            min-height: 3rem !important;
            font-size: 1rem !important;
        }
    </style>
</head>
<body class="text-slate-900 dark:text-slate-100 min-h-screen flex flex-col" style="background: linear-gradient(rgba(2, 6, 23, 0.84), rgba(2, 6, 23, 0.72)), url('/storage/categories/cat-1.jpg') center / cover no-repeat fixed; background-color: #020617;">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-sky-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 bg-clip-text text-transparent">
                    {{ site_name() }}
                </a>
                <div class="flex items-center space-x-3">
                    @include('components.theme-toggle')
                </div>
            </div>
        </div>
    </header>

    <!-- ========== CONTENU (formulaire Livewire Filament) ========== -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        {{ $slot }}
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} Tous droits réservés.</p>
    </footer>

    @livewire(Filament\Livewire\Notifications::class)
    @filamentScripts(withCore: true)
</body>
</html>
