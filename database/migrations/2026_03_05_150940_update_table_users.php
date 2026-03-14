<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->ulid('ulid')->unique()->after('id');

            $table->string('phone')->nullable()->after('email');

            $table->string('avatar')->nullable()->after('phone');

            $table->unsignedBigInteger('role_id')->default(2)->after('avatar');

            $table->tinyInteger('status')->default(1)->after('role_id');

            $table->timestamp('last_login_at')->nullable()->after('status');

            $table->string('provider')->nullable()->after('last_login_at');

            $table->string('provider_id')->nullable()->after('provider');
            $table->string('address')->nullable();
            $table->foreignUlid('district_id')->nullable();
            $table->foreignUlid('province_id')->index();
            $table->foreignUlid('country_id')->default('Vietnam')->index();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'ulid',
                'phone',
                'avatar',
                'role_id',
                'status',
                'last_login_at',
                'provider',
                'provider_id',
                'address',
                'district_id',
                'province_id',
                'country_id',
                'deleted_at'
            ]);
        });
    }
};