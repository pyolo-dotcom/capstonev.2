<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('fuel_consumptions', function (Blueprint $table) {
        $table->decimal('fuel_price', 8, 2)->nullable();
        $table->decimal('total_cost', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('fuel_consumptions', function (Blueprint $table) {
        $table->dropColumn(['fuel_price', 'total_cost']);
    });
}

};
