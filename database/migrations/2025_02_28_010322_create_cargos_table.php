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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('plate_no');
            $table->string('eir_no');
            $table->string('container_van_no');
            $table->string('size');
            $table->string('shipper_consignee');
            $table->string('voyage_vessel');
            $table->string('voyage_no');
            $table->string('pickup_location');
            $table->string('delivery_location');
            $table->string('status')->default('deLivered');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
