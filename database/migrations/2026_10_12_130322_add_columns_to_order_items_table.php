<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Colonnes attendues par le modèle OrderItem
            $table->foreignId('order_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->after('order_id')->constrained()->nullOnDelete();
            $table->integer('quantity')->default(1)->after('product_id');
            $table->decimal('unit_price', 10, 2)->after('quantity');
            $table->decimal('total', 10, 2)->after('unit_price');
            $table->string('product_name')->after('total');
            $table->string('product_sku')->nullable()->after('product_name');
            $table->json('product_options')->nullable()->after('product_sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['order_id', 'product_id', 'quantity', 'unit_price', 'total', 'product_name', 'product_sku', 'product_options']);
        });
    }
};
