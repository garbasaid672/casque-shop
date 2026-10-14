<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Déconnexion admin -> page d'accueil de la boutique (au lieu du login admin)
        $this->app->bind(
            \Filament\Auth\Http\Responses\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Habillage aux couleurs de la boutique (fond photo + carte du login admin)
        FilamentView::registerRenderHook(
            PanelsRenderHook::STYLES_AFTER,
            fn (): string => Blade::render(<<<'HTML'
                <style>
                    .fi-simple-layout {
                        background: linear-gradient(rgba(2, 6, 23, 0.84), rgba(2, 6, 23, 0.72)),
                            url('/storage/categories/cat-1.jpg') center / cover no-repeat !important;
                        min-height: 100vh;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                    }
                    .fi-simple-main-ctn {
                        margin: 0 auto !important;
                        width: 100% !important;
                        max-width: 32rem !important;
                        display: flex !important;
                        flex-direction: column !important;
                        align-items: center !important;
                        justify-content: center !important;
                    }
                    .fi-simple-main {
                        width: 100% !important;
                        max-width: 32rem !important;
                        margin: 0 auto !important;
                        background: rgba(255, 255, 255, 0.97) !important;
                        border-radius: 1.25rem !important;
                        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.55) !important;
                        border: 1px solid rgba(255, 255, 255, 0.25) !important;
                    }
                    .dark .fi-simple-main {
                        background: rgba(15, 23, 42, 0.97) !important;
                    }

                    /* ===== Sidebar admin bleu nuit (tout le texte en blanc) ===== */
                    .fi-main-sidebar {
                        background: linear-gradient(180deg, #020617 0%, #0b1e3a 50%, #143063 100%) !important;
                    }
                    .fi-main-sidebar .fi-sidebar-header,
                    .fi-main-sidebar .fi-sidebar-header a {
                        color: #ffffff !important;
                    }
                    .fi-main-sidebar .fi-sidebar-group-btn,
                    .fi-main-sidebar span.fi-sidebar-group-label {
                        color: #ffffff !important;
                    }
                    .fi-main-sidebar a.fi-sidebar-item-btn,
                    .fi-main-sidebar span.fi-sidebar-item-label {
                        color: #ffffff !important;
                    }
                    .fi-main-sidebar a.fi-sidebar-item-btn:hover {
                        background-color: rgba(255, 255, 255, 0.16) !important;
                    }
                    .fi-main-sidebar .fi-sidebar-item-icon {
                        color: #ffffff !important;
                    }
                    .fi-main-sidebar .fi-sidebar-item-badge-ctn {
                        color: #ffffff !important;
                    }
                    .fi-main-sidebar li.fi-sidebar-item.fi-active > a.fi-sidebar-item-btn {
                        background-color: #fbbf24 !important;
                    }
                    .fi-main-sidebar li.fi-sidebar-item.fi-active > a.fi-sidebar-item-btn,
                    .fi-main-sidebar li.fi-sidebar-item.fi-active span.fi-sidebar-item-label,
                    .fi-main-sidebar li.fi-sidebar-item.fi-active .fi-sidebar-item-icon {
                        color: #020617 !important;
                        font-weight: 700;
                    }

                    /* ===== Marque GMS Audio en couleur (connexion + dashboard admin) ===== */
                    .fi-logo {
                        background: linear-gradient(90deg, #0284c7 0%, #2563eb 45%, #f59e0b 100%);
                        -webkit-background-clip: text;
                        background-clip: text;
                        color: transparent !important;
                        font-weight: 800;
                        font-size: 1.75rem;
                        letter-spacing: 0.02em;
                    }

                    /* ===== Padding page de connexion : téléphone puis ordinateur ===== */
                    .fi-simple-main-ctn {
                        padding: 1rem !important;
                    }
                    @media (min-width: 768px) {
                        .fi-simple-main-ctn {
                            padding: 2.5rem 2rem !important;
                        }
                    }
                </style>
                HTML),
        );
    }
}
