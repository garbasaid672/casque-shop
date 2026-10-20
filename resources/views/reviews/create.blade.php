<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Votre avis - {{ site_name() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.theme-config')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <header class="border-b border-sky-100 bg-white dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto flex h-16 max-w-3xl items-center justify-between px-4">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-sky-700 dark:text-sky-400">{{ site_name() }}</a>
            @include('components.theme-toggle')
        </div>
    </header>

    <main class="mx-auto max-w-xl px-4 py-12">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-sky-700 dark:text-sky-400">Commande {{ $orderNumber }}</p>
            <h1 class="mt-2 text-2xl font-extrabold">Comment s’est passée votre expérience ?</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                Les avis sont réservés aux commandes payées ou livrées. Votre nom sera affiché avec votre prénom et l’initiale de votre nom.
            </p>

            @if (session('status'))
                <div role="status" class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-200">
                    {{ session('status') }}
                </div>
            @else
                <form method="POST" action="{{ route('reviews.store', $orderNumber) }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold">E-mail utilisé pour la commande</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-950">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <fieldset>
                        <legend class="mb-2 text-sm font-semibold">Votre note</legend>
                        <div class="flex flex-wrap gap-2">
                            @foreach ([5 => 'Excellent', 4 => 'Très bien', 3 => 'Bien', 2 => 'Décevant', 1 => 'Très décevant'] as $rating => $label)
                                <label class="cursor-pointer">
                                    <input class="peer sr-only" type="radio" name="rating" value="{{ $rating }}" @checked((int) old('rating', 5) === $rating)>
                                    <span class="inline-flex rounded-lg border border-slate-300 px-3 py-2 text-sm peer-checked:border-amber-400 peer-checked:bg-amber-100 peer-checked:text-amber-950 dark:border-slate-700 dark:peer-checked:bg-amber-950 dark:peer-checked:text-amber-200">
                                        {{ $rating }} ★ <span class="ml-1 hidden sm:inline">{{ $label }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </fieldset>

                    <div>
                        <label for="comment" class="mb-1 block text-sm font-semibold">Votre commentaire</label>
                        <textarea id="comment" name="comment" rows="5" minlength="10" maxlength="1500" required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('comment') }}</textarea>
                        @error('comment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-sky-600 px-5 py-3 font-bold text-white hover:bg-sky-700">
                        Envoyer mon avis
                    </button>
                    <p class="text-center text-xs text-slate-500 dark:text-slate-400">Votre avis sera publié après vérification par notre équipe.</p>
                </form>
            @endif
        </section>
    </main>
</body>
</html>
