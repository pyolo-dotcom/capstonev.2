<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAverageKmLToTrucksTable extends Migration
{
    public function up()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->decimal('average_km_l', 8, 2)->nullable()->after('plate_number');
        });
    }
    
    public function down()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn('average_km_l');
        });
    }
}