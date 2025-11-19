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
        Schema::table('products', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('description');
        });

        Schema::table('products', function (Blueprint $table) {
            // Re-add it as nullable
            $table->text('description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop nullable version
            $table->dropColumn('description');
        });

        Schema::table('products', function (Blueprint $table) {
            // Re-add it as NOT NULL
            $table->text('description');
        });
    }
    
};
