<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->text('description')->nullable()->after('image');
            $table->string('category')->default('makanan')->after('description'); // makanan | minuman
            $table->integer('stock')->default(50)->after('category');
            $table->boolean('is_available')->default(true)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'stock', 'is_available']);
        });
    }
};
