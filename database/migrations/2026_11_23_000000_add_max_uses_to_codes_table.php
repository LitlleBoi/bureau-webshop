<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            // Hoeveel producten met deze code geclaimd mogen worden
            $table->unsignedInteger('max_uses')->default(1)->after('code');
            // Hoeveel producten er al mee geclaimd zijn
            $table->unsignedInteger('uses_count')->default(0)->after('max_uses');
        });

        // Bestaande gebruikte codes hebben hun ene product al geclaimd
        DB::table('codes')->where('used', true)->update(['uses_count' => 1]);
    }

    public function down(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->dropColumn(['max_uses', 'uses_count']);
        });
    }
};
