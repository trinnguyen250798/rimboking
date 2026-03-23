<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {

            // ================= DESCRIPTION =================
            $table->text('short_description')->nullable()->after('description');


            // ================= RATING =================
            $table->decimal('rating_avg', 3, 2)->default(0)->after('star_rating');
            $table->integer('rating_count')->default(0)->after('rating_avg');

            // ================= PRICE META =================
            $table->integer('price_from')->nullable()->index()->after('website');
            $table->integer('price_to')->nullable()->after('price_from');

            // ================= MEDIA =================
            $table->integer('total_images')->default(0)->after('thumbnail');

            // ================= POLICY =================
            $table->boolean('is_refundable')->default(true)->after('total_images');
            $table->boolean('is_free_cancellation')->default(false)->after('is_refundable');
            $table->text('checkin_policy')->nullable()->after('is_free_cancellation');
            $table->text('checkout_policy')->nullable()->after('checkin_policy');

            // ================= FLAGS =================
            $table->boolean('is_featured')->default(false)->index()->after('checkout_policy');
            $table->boolean('is_top_deal')->default(false)->after('is_featured');

            // ================= BUSINESS / TRACKING =================
            $table->integer('booking_count')->default(0)->index()->after('is_top_deal');
            $table->integer('view_count')->default(0)->after('booking_count');

            // ================= TYPE =================
            $table->string('type')->nullable()->after('view_count'); 
            // hotel, resort, villa, homestay...

            // ================= JSON CONFIG =================
            $table->json('languages')->nullable()->after('type');
            $table->json('payment_options')->nullable()->after('languages');

            // ================= SEO =================
            $table->string('meta_title')->nullable()->after('payment_options');
            $table->text('meta_description')->nullable()->after('meta_title');

            // ================= SOFT DELETE =================
            $table->softDeletes();

            // ================= INDEX OPTIMIZE =================
            $table->index(
                ['province_code', 'star_rating', 'price_from'],
                'idx_hotels_filter'
            );
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {

            $table->dropColumn([
                'short_description',
                'rating_avg',
                'rating_count',
                'price_from',
                'price_to',
                'total_images',
                'is_refundable',
                'is_free_cancellation',
                'checkin_policy',
                'checkout_policy',
                'is_featured',
                'is_top_deal',
                'booking_count',
                'view_count',
                'type',
                'languages',
                'payment_options',
                'meta_title',
                'meta_description',
                'deleted_at',
            ]);

            $table->dropIndex('idx_hotels_filter');
        });
    }
};