<x-filament-widgets::widget>
    <div class="space-y-4">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-700 via-primary-600 to-sky-500 px-6 py-6 shadow-lg shadow-primary-950/10 sm:px-8">
            <div class="pointer-events-none absolute -right-8 -top-16 size-48 rounded-full border-[24px] border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-20 right-28 size-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="relative flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">Bienvenue</p>
                    <strong class="mt-1 block text-3xl font-black tracking-tight text-white sm:text-4xl">Administrateur</strong>
                </div>
                <div class="sm:text-right">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Tableau de bord</h1>
                </div>
            </div>
        </div>

        <style>
            .admin-summary-kpis {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
            }

            .admin-summary-card {
                min-width: 0;
                padding: 1.25rem;
                border: 1px solid rgb(229 231 235);
                border-radius: 0.875rem;
                background: white;
            }

            .admin-summary-label {
                white-space: nowrap;
            }

            .dark .admin-summary-card {
                border-color: rgb(55 65 81);
                background: rgb(17 24 39);
            }

            @media (max-width: 640px) {
                .admin-summary-kpis {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    column-gap: 1rem;
                    row-gap: 0.75rem;
                }

                .admin-summary-card {
                    padding: 1rem;
                }

                .admin-summary-card.orders-total {
                    grid-column: 1 / -1;
                }

                .admin-summary-label {
                    font-size: 0.95rem;
                    line-height: 1.35;
                }

                .admin-summary-value {
                    font-size: clamp(1rem, 4vw, 1.5rem);
                }

                .admin-summary-detail {
                    font-size: 0.72rem;
                    line-height: 1.35;
                }
            }
        </style>

        <div class="admin-summary-kpis">
            <section class="admin-summary-card">
                <p class="admin-summary-label text-sm font-semibold text-gray-500 dark:text-gray-400">Chiffre d’affaires</p>
                <p class="admin-summary-value mt-2 break-words text-2xl font-extrabold tracking-tight text-gray-950 dark:text-white">{{ $revenue }}</p>
                <p class="admin-summary-detail mt-1 text-xs text-gray-500 dark:text-gray-400">Total des paiements confirmés</p>
            </section>

            <section class="admin-summary-card">
                <p class="admin-summary-label text-sm font-semibold text-gray-500 dark:text-gray-400">Paiements reçus</p>
                <p class="admin-summary-value mt-2 text-2xl font-extrabold tracking-tight text-gray-950 dark:text-white">{{ number_format($payments, 0, ',', ' ') }}</p>
                <p class="admin-summary-detail mt-1 text-xs text-gray-500 dark:text-gray-400">Commandes payées</p>
            </section>

            <section class="admin-summary-card orders-total">
                <p class="admin-summary-label text-sm font-semibold text-gray-500 dark:text-gray-400">Commandes totales</p>
                <p class="admin-summary-value mt-2 text-2xl font-extrabold tracking-tight text-gray-950 dark:text-white">{{ number_format($orders, 0, ',', ' ') }}</p>
                <p class="admin-summary-detail mt-1 text-xs text-gray-500 dark:text-gray-400">Toutes les commandes</p>
            </section>
        </div>
    </div>
</x-filament-widgets::widget>
