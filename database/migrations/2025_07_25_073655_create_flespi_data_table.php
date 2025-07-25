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
        Schema::create('flespi_data', function (Blueprint $table) {
            $table->id();
            $table->json('payload')->nullable(); // Store entire payload as JSON
            $table->string('device_id')->nullable(); // Example specific field
            $table->float('latitude')->nullable(); // Example specific field
            $table->float('longitude')->nullable(); // Example specific field
            $table->timestamp('timestamp')->nullable(); // Example specific field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flespi_data');
    }
};
