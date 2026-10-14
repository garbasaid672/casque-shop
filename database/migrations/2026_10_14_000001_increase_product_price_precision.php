<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Précision prix en EUR : 4 décimales pour tomber juste en FCFA.
// Ex : 15.3846 × 650 = 10 000 FCFA, 23.0769 × 650 = 15 000 FCFA.
// Avec 2 décimales c'était impossible (15.38 → 9 997 FCFA).
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 4)->change();
            $table->decimal('compare_at_price', 10, 4)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
            $table->decimal('compare_at_price', 10, 2)->nullable()->change();
        });
    }
};
