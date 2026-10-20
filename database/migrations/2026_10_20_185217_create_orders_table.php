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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
                ->index()
                ->constrained()->cascadeOnDelete();
            $table->enum('type',[
                'umrah',
                'hajj',
                'events',
                'outbound',
                'honeymoon'
            ])->index();
            $table->integer('number_of_pilgrims')->default(0);
            $table->dateTime('departure_at');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->index()->nullable();
            $table->string('nationality');
            $table->text('notes')->nullable();
            $table->enum('payment_type',['cod','visa','knet'])
                ->index()
                ->default('visa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
