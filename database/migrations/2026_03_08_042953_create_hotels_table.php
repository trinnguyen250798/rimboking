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

            $table->string('address')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->index();
            $table->string('country')->default('Vietnam');

            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();

            $table->tinyInteger('star_rating')->default(0)->index();

            $table->time('checkin_time')->nullable();
            $table->time('checkout_time')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('thumbnail')->nullable();

            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->tinyInteger('status')->default(1)->index();

            $table->timestamps();

            $table->index(['city','district']);
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