<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 191)->unique();
            $table->string('value');
            $table->string('description');
            $table->integer('weight')->default(0)->nullable();
        });

        // Populate
        DB::table('settings')->insert(['id' => 1, 'name' => 'Use System Tables', 'code' => 'use_system_tables', 'value' => 0, 'description' => '', 'weight' => 100]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}