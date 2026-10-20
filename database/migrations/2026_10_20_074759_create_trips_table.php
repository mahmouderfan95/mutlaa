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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->enum('type',[
                'umrah',
                'hajj',
                'events',
                'outbound',
                'honeymoon'
            ])->index();
            $table->json('title');
            $table->json('description');

            $table->json('itinerary')->nullable();
            $table->json('includes')->nullable();
            $table->json('excludes')->nullable();
            $table->json('hotel_name')->nullable();

            $table->string('cover_image')->nullable();
            $table->dateTime('departure_at')->index();
            $table->dateTime('return_at')->nullable();
            $table->unsignedSmallInteger('duration_days');
            $table->unsignedSmallInteger('duration_nights')->default(0);

            $table->decimal('price', 12, 3);
            $table->char('currency', 3)->default('KWD');

            $table->unsignedInteger('available_seats')->default(0);
            $table->unsignedInteger('booked_seats')->default(0);
            $table->unsignedTinyInteger('hotel_stars')->nullable();
            $table->enum('status',[
               'draft',
               'published',
               'cancelled',
               'completed'
            ])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
