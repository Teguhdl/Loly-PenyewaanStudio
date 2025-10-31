<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->boolean('return_requested')->default(false)
                ->after('status')
                ->comment('User mengajukan pengembalian');

            $table->boolean('return_approved')->default(false)
                ->after('return_requested')
                ->comment('Admin telah menyetujui pengembalian');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['return_requested', 'return_approved']);
        });
    }
};
