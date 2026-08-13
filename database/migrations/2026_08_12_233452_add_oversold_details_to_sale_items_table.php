<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->integer('oversold_quantity')->nullable()->after('is_oversold');
            $table->decimal('oversold_unit_cost', 10, 2)->nullable()->after('oversold_quantity');
        });
    }

    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['oversold_quantity', 'oversold_unit_cost']);
        });
    }
};