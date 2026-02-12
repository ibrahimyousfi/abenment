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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('user_id');
            $table->string('payment_method')->default('cash')->after('total_amount'); // cash, card, transfer
            $table->decimal('discount_amount', 10, 2)->default(0)->after('payment_method');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('discount_amount');
            $table->string('status')->default('completed')->after('tax_amount'); // completed, pending, cancelled
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'payment_method', 'discount_amount', 'tax_amount', 'status']);
        });
    }
};
