<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paiement - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (remplace Vite en dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Widget de paiement KkiaPay (Mobile Money, carte bancaire) -->
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-sky-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-sky-700 dark:text-sky-400">
                    {{ site_name() }}
                </a>
                <div class="flex items-center space-x-3">
                    @include('components.theme-toggle')
                    <a href="{{ route('shop.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 font-medium text-sm">
                        Continuer mes achats
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== PAIEMENT ========== -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-lg">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-8 sm:p-10 text-center">
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Paiement sécurisé</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">
                    Commande <span class="font-bold text-sky-700 dark:text-sky-400">{{ $order->order_number }}</span>
                </p>

                <!-- Montant -->
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-5 mt-6">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total à payer</p>
                    <p class="text-3xl font-extrabold text-sky-700 dark:text-sky-400 mt-1">{{ number_format($order->total, 0, ',', ' ') }} FCFA</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">MTN MoMo, Moov Money, carte bancaire via KkiaPay</p>
                </div>

                <!-- Message d'erreur -->
                <div id="pay-error" class="hidden bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg px-4 py-3 mt-6"></div>

                <!-- Bouton de paiement -->
                <button id="pay-btn" onclick="payerKkiaPay()" class="w-full bg-amber-400 text-slate-950 font-bold py-3 rounded-lg hover:bg-amber-300 transition-colors mt-6">
                    Payer {{ number_format($order->total, 0, ',', ' ') }} FCFA
                </button>
                <p id="pay-loading" class="hidden text-sm text-slate-500 dark:text-slate-400 mt-4">Vérification du paiement en cours…</p>

                <a href="{{ route('checkout.success', $order->order_number) }}" class="inline-block text-sm text-slate-500 dark:text-slate-400 hover:text-sky-600 mt-4">
                    Payer plus tard
                </a>
            </div>
        </div>
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.</p>
    </footer>

    <script>
        const verifyUrl = @json(route('payment.verify', $order->order_number));

        function showError(message) {
            const box = document.getElementById('pay-error');
            box.textContent = message;
            box.classList.remove('hidden');
            document.getElementById('pay-loading').classList.add('hidden');
            document.getElementById('pay-btn').disabled = false;
        }

        function payerKkiaPay() {
            document.getElementById('pay-error').classList.add('hidden');

            // Widget bloqué (bloqueur de pub, connexion...) : message clair au lieu d'un clic sans effet
            if (typeof openKkiapayWidget !== 'function') {
                showError('Fenêtre KkiaPay bloquée : désactivez votre bloqueur de pub pour ce site, rechargez la page puis réessayez.');
                return;
            }

            document.getElementById('pay-btn').disabled = true;

            // Ouvre la fenêtre de paiement KkiaPay (montant en FCFA)
            openKkiapayWidget({
                amount: {{ (int) $order->total }},
                api_key: @json(config('kkiapay.public_key')),
                sandbox: {{ config('kkiapay.sandbox') ? 'true' : 'false' }},
                data: @json($order->order_number),
                name: @json(trim($order->billing_first_name . ' ' . $order->billing_last_name)),
                email: @json($order->email),
                phone: @json($order->phone ?? ''),
                theme: '#0284c7',
            });

            // Succès côté widget : on fait vérifier la transaction par le serveur
            // (ne jamais faire confiance au seul widget : anti-fraude)
            addSuccessListener(async (response) => {
                document.getElementById('pay-loading').classList.remove('hidden');

                try {
                    const res = await fetch(verifyUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                        },
                        body: JSON.stringify({ transactionId: response.transactionId }),
                    });
                    const data = await res.json();

                    if (data.ok) {
                        window.location.href = data.redirect;
                    } else {
                        showError(data.message || 'Paiement non confirmé.');
                    }
                } catch (e) {
                    showError('Vérification impossible, réessayez.');
                }
            });

            addFailedListener((error) => {
                showError((error && error.failureMessage) || 'Le paiement a échoué ou a été annulé.');
            });
        }
    </script>
</body>
</html>
