<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('table_number');
            $table->text('notes')->nullable()->after('customer_name');
            $table->string('payment_status')->default('unpaid')->after('status'); // unpaid | paid | failed
            $table->string('payment_method')->default('qris')->after('payment_status'); // qris | cash
            $table->string('payment_token')->nullable()->after('payment_method'); // simulasi token
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'notes', 'payment_status', 'payment_method', 'payment_token']);
        });
    }
};
