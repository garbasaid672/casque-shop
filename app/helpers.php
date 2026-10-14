<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

if (! function_exists('setting')) {
    // Lit un réglage global (table settings) avec cache + fallback.
    // Ex : setting('site_name', config('app.name', 'GMS Audio'))
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            if (! Schema::hasTable('settings')) {
                return $default;
            }

            return cache()->rememberForever(
                "setting.{$key}",
                fn () => Setting::where('key', $key)->value('value') ?? $default
            );
        } catch (\Throwable) {
            return $default;
        }
    }
}

if (! function_exists('site_name')) {
    // Nom du site modifiable depuis l'admin (/admin > Réglages).
    function site_name(): string
    {
        return (string) setting('site_name', config('app.name', 'GMS Audio'));
    }
}
