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
        Schema::table('users', function (Blueprint $table) {
            $table->string('truck_id')->nullable()->change(); // Gawing nullable ang truck_id
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('truck_id')->nullable(false)->change(); // I-revert kung kailangan
        });
    }
};
