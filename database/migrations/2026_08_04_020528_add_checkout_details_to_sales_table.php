<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('customer_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->decimal('subtotal', 10, 2)->default(0)->after('customer_phone');
            $table->enum('discount_type', ['flat', 'percent'])->nullable()->after('subtotal');
            $table->decimal('discount_value', 10, 2)->default(0)->after('discount_type');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_phone', 'subtotal', 'discount_type', 'discount_value']);
        });
    }
};