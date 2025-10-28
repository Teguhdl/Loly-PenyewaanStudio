<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_virtual_world', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('virtual_world_id')->constrained('virtual_worlds')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_virtual_world');
    }
};
