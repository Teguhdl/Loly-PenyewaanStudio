<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔹 Tambahan untuk virtual_worlds
        Schema::table('virtual_worlds', function (Blueprint $table) {
            if (!Schema::hasColumn('virtual_worlds', 'code')) {
                $table->string('code')->unique()->after('id');
            }
            if (!Schema::hasColumn('virtual_worlds', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('description');
            }
            if (!Schema::hasColumn('virtual_worlds', 'max_rent_duration')) {
                $table->integer('max_rent_duration')->default(5)->after('is_available');
            }
        });

        // 🔹 Tambahan untuk rentals
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'status')) {
                $table->enum('status', ['ongoing', 'returned', 'overdue'])->default('ongoing')->after('id');
            }
            if (!Schema::hasColumn('rentals', 'returned_at')) {
                $table->timestamp('returned_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('rentals', 'total_penalty')) {
                $table->decimal('total_penalty', 10, 2)->nullable()->after('returned_at');
            }
            if (!Schema::hasColumn('rentals', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('total_penalty');
            }
        });

        // 🔹 Tambahan untuk penalties
        Schema::table('penalties', function (Blueprint $table) {
            if (!Schema::hasColumn('penalties', 'amount')) {
                $table->decimal('amount', 10, 2)->after('rental_id');
            }
            if (!Schema::hasColumn('penalties', 'is_paid')) {
                $table->boolean('is_paid')->default(false)->after('amount');
            }
            if (!Schema::hasColumn('penalties', 'payment_id')) {
                $table->foreignId('payment_id')->nullable()->after('is_paid');
            }
        });
    }

    public function down(): void
    {
        Schema::table('virtual_worlds', function (Blueprint $table) {
            $table->dropColumn(['code', 'is_available', 'max_rent_duration']);
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['status', 'returned_at', 'total_penalty', 'payment_status']);
        });

        Schema::table('penalties', function (Blueprint $table) {
            $table->dropColumn(['amount', 'is_paid', 'payment_id']);
        });
    }
};
