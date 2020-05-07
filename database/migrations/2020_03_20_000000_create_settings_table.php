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
            $table->string('description')->nullable();
            $table->string('value');
            $table->string('code', 191)->unique();
            $table->enum('type', ['string', 'integer', 'flag']);
        });

        // Populate
        DB::table('settings')->insert(['name' => 'Show System Tables', 'code' => 'dev_mode_tables', 'value' => 0, 'type' => 'flag']);
        DB::table('settings')->insert(['name' => 'Show System Fields', 'code' => 'dev_mode_fields', 'value' => 0, 'type' => 'flag']);
        DB::table('settings')->insert(['name' => 'Images  Folder Name  Lenght', 'code' => 'local_image_folder_lenght', 'value' => 1, 'type' => 'integer']);
        DB::table('settings')->insert(['name' => 'Max Width Local Image', 'code' => 'local_image_width_max', 'value' => 1920, 'type' => 'integer']);
        DB::table('settings')->insert(['name' => 'Max Height Local Image', 'code' => 'local_image_height_max', 'value' => 1920, 'type' => 'integer']);
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