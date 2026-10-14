<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commande confirmée - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (remplace Vite en dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

    <!-- ========== CONFIRMATION ========== -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-lg">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl p-8 sm:p-10 text-center">
                <!-- Icône succès -->
                <div class="w-16 h-16 mx-auto rounded-full bg-green-100 dark:bg-green-950 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-5">Merci pour votre commande !</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">
                    Votre commande <span class="font-bold text-sky-700 dark:text-sky-400">{{ $order->order_number }}</span> est bien enregistrée.
                </p>

                <!-- Récapitulatif -->
                <div class="text-left bg-slate-50 dark:bg-slate-800 rounded-xl p-5 mt-6 space-y-2 text-sm">
                    @foreach($order->items as $item)
                        <div class="flex justify-between">
                            <span class="text-slate-600 dark:text-slate-300">{{ $item->product_name }} × {{ $item->quantity }}</span>
                            <span class="font-semibold">{{ number_format($item->total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between border-t border-slate-200 dark:border-slate-700 pt-2">
                        <span class="text-slate-600 dark:text-slate-300">Livraison</span>
                        <span class="font-semibold">{{ number_format($order->shipping_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between font-bold text-base">
                        <span>Total</span>
                        <span class="text-sky-700 dark:text-sky-400">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 pt-1">
                        Paiement : {{ ['kkiapay' => 'En ligne (KkiaPay)', 'mobile_money' => 'Mobile Money', 'cash_on_delivery' => 'À la livraison'][$order->payment_method] ?? $order->payment_method }}
                        @if($order->payment_status === 'paid')
                            <span class="inline-block ml-1 font-bold text-green-600 dark:text-green-400">— payé ✓</span>
                        @else
                            (en attente)
                        @endif
                    </p>
                </div>

                @if($order->payment_method === 'kkiapay' && $order->payment_status !== 'paid')
                    <a href="{{ route('payment.show', $order->order_number) }}" class="block w-full bg-amber-400 text-slate-950 font-bold py-3 rounded-lg hover:bg-amber-300 transition-colors mt-6">
                        Payer maintenant
                    </a>
                @endif

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-6">
                    Nous vous appellerons au <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $order->phone }}</span> pour confirmer la livraison.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 mt-8">
                    <a href="{{ route('shop.index') }}" class="flex-1 bg-sky-600 text-white font-bold py-2.5 rounded-lg hover:bg-sky-700 text-sm text-center">
                        Retour à la boutique
                    </a>
                    <a href="{{ route('home') }}" class="flex-1 border border-slate-300 dark:border-slate-700 font-bold py-2.5 rounded-lg hover:border-sky-500 text-sm text-center">
                        Accueil
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.</p>
    </footer>
</body>
</html>
