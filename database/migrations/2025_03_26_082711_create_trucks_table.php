<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('cr_number');
            $table->date('date');
            $table->string('mv_file_number');
            $table->string('plate_number')->unique();
            $table->string('engine_number')->unique();
            $table->string('chassis_number')->unique();
            $table->string('denomination');
            $table->string('piston_displacement');
            $table->string('number_of_cylinders');
            $table->string('fuel');
            $table->string('make');
            $table->string('body_type');
            $table->string('body_number');
            $table->string('year_model');
            $table->string('gross_weight');
            $table->string('net_weight');
            $table->string('shipping_weight');
            $table->string('net_capacity');
            $table->string('owner_name');
            $table->string('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trucks');
    }
};