<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::updateOrCreate(
            ['key' => 'admin_phone'],
            ['value' => '01 53 93 85 88']
        );
    }

    public function down(): void
    {
        // On conserve le réglage en cas de rollback.
    }
};
