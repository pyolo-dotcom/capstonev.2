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
        Schema::table('profits', function (Blueprint $table) {
            $table->softDeletes(); // Ito ang magdadagdag ng `deleted_at` column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('profits', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Ito ang magtatanggal ng `deleted_at` column
        });
    }
};
