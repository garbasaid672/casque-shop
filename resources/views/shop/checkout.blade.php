<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commander - {{ site_name() }}</title>
    <!-- Tailwind CSS via CDN (remplace Vite en dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <!-- Police Inter via Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-sky-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 bg-clip-text text-transparent">
                    {{ site_name() }}
                </a>
                <div class="flex items-center space-x-3">
                    @include('components.theme-toggle')
                    <a href="{{ route('product.show', $product) }}" class="text-slate-600 dark:text-slate-300 hover:text-sky-600 font-medium text-sm">
                        &larr; Retour au produit
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-8">Finaliser la commande</h1>

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg px-4 py-3 mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $unitFcfa = (int) round($product->price * \App\Models\Product::FCFA_RATE);
                $subtotal = $unitFcfa * $quantity;
                $shipping = \App\Http\Controllers\CheckoutController::SHIPPING_FCFA;
                $total = $subtotal + $shipping;
                $fmt = fn ($n) => number_format($n, 0, ',', ' ') . ' FCFA';
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- ========== FORMULAIRE ========== -->
                <form method="POST" action="{{ route('checkout.store', $product) }}" class="lg:col-span-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-8 space-y-5">
                    @csrf
                    <input type="hidden" name="quantity" value="{{ $quantity }}">

                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Vos coordonnées</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Prénom</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user ? explode(' ', $user->name)[0] : '') }}" required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Nom</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->name ?? '') }}" required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Adresse email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Numéro de téléphone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required
                                   placeholder="+228 90 00 00 00"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" required
                               placeholder="Rue, avenue, repère..."
                               class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="quartier" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Quartier</label>
                            <input type="text" id="quartier" name="quartier" value="{{ old('quartier', $user->quartier ?? '') }}" required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Ville</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" required
                                    placeholder="Ex : Akpakpa, Godomey, Gbegamey"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900 dark:text-white pt-2">Moyen de paiement</h2>

                    @if($kkiapayConfigured ?? false)
                    <label class="flex items-start gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-3 cursor-pointer has-[:checked]:border-sky-500 has-[:checked]:ring-2 has-[:checked]:ring-sky-500">
                        <input type="radio" name="payment_method" value="kkiapay" checked class="mt-1 text-sky-600 focus:ring-sky-500">
                        <span>
                            <span class="block font-semibold text-sm">Paiement en ligne (KkiaPay)</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">MTN MoMo, Moov Money, carte bancaire — paiement sécurisé immédiat.</span>
                        </span>
                    </label>
                    @endif

                    <label class="flex items-start gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-3 cursor-pointer has-[:checked]:border-sky-500 has-[:checked]:ring-2 has-[:checked]:ring-sky-500">
                        <input type="radio" name="payment_method" value="cash_on_delivery" {{ ($kkiapayConfigured ?? false) ? '' : 'checked' }} {{ old('payment_method') === 'cash_on_delivery' ? 'checked' : '' }} class="mt-1 text-sky-600 focus:ring-sky-500">
                        <span>
                            <span class="block font-semibold text-sm">Paiement à la livraison</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400 mt-1">Payez en espèces à la réception de votre colis.</span>
                        </span>
                    </label>

                    <button type="submit" class="w-full bg-amber-400 text-slate-950 font-bold py-3 rounded-lg hover:bg-amber-300 transition-colors">
                        Payer {{ $fmt($total) }}
                    </button>
                </form>

                <!-- ========== RÉCAPITULATIF ========== -->
                <aside class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-8 lg:sticky lg:top-6">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Récapitulatif</h2>
                        <div class="flex gap-4">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ product_image_url($product->images[0]) }}" alt="{{ $product->name }}"
                                     class="w-20 h-20 object-cover rounded-lg">
                            @endif
                            <div>
                                <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Quantité : {{ $quantity }}</p>
                            </div>
                        </div>
                        <dl class="mt-6 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Sous-total</dt>
                                <dd class="font-semibold">{{ $fmt($subtotal) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Livraison</dt>
                                <dd class="font-semibold">{{ $fmt($shipping) }}</dd>
                            </div>
                            <div class="flex justify-between border-t border-slate-200 dark:border-slate-700 pt-3 text-base">
                                <dt class="font-bold">Total</dt>
                                <dd class="font-extrabold text-sky-700 dark:text-sky-400">{{ $fmt($total) }}</dd>
                            </div>
                        </dl>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <!-- ========== FOOTER SIMPLE ========== -->
    <footer class="bg-slate-950 text-slate-500 py-6 text-center text-sm mt-6">
        <p>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.</p>
    </footer>
</body>
</html>
