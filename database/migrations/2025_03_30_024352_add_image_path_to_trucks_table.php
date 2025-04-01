<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->string('image_path')
                  ->nullable()
                  ->after('id'); // Places image column right after ID
        });
    }

    public function down()
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};