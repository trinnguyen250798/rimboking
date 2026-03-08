<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->string('address');
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('city');
            $table->string('country')->default('Vietnam');

            // Map location
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Hotel info
            $table->tinyInteger('star')->default(0);

            $table->time('checkin_time')->nullable();
            $table->time('checkout_time')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('thumbnail')->nullable();

            // Owner
            $table->ulid('owner_id')->index();

            // Status
            $table->tinyInteger('status')->default(1)->index();

            $table->timestamps();

            // Index search
            $table->index('ulid');
            $table->index('city');
            $table->index(['latitude', 'longitude']);
            $table->index('star');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};