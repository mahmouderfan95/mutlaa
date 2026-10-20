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
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('price_after_discount', 12, 3)
                ->nullable()
                ->after('price');
            $table->dateTime('offer_starts_at')
                ->nullable()
                ->after('price_after_discount');

            $table->dateTime('offer_ends_at')
                ->nullable()
                ->after('offer_starts_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
