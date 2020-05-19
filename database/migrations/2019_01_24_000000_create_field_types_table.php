<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('description')->nullable();
            $table->boolean('flag_sorted')->default(1);
            $table->boolean('flag_system')->default(0);
            $table->integer('weight')->default(0);
        });

        // Populate
        DB::table('field_types')->insert(['id' => 1, 'name' => 'Short Text', 'code' => 'varchar', 'description' => 'Short', 'flag_sorted' => 1, 'weight' => 300]);
        DB::table('field_types')->insert(['id' => 2, 'name' => 'Checkbox', 'code' => 'flag', 'description' => 'Checkbox', 'flag_sorted' => 0, 'weight' => 290]);
        DB::table('field_types')->insert(['id' => 3, 'name' => 'Integer', 'code' => 'integer', 'description' => 'Integer', 'flag_sorted' => 1, 'weight' => 280]);
        DB::table('field_types')->insert(['id' => 4, 'name' => 'Long Text', 'code' => 'text', 'description' => 'Long Text', 'weight' => 270]);
        DB::table('field_types')->insert(['id' => 5, 'name' => 'Date and Time', 'code' => 'datetime', 'description' => 'Date and Time', 'flag_sorted' => 1, 'weight' => 260]);
        DB::table('field_types')->insert(['id' => 6, 'name' => 'Data Source (tables)', 'code' => 'tables', 'description' => 'Data Source (tables)', 'flag_sorted' => 0, 'weight' => 250]);
        DB::table('field_types')->insert(['id' => 7, 'name' => 'Weight (sorting)', 'code' => 'weight', 'description' => 'Weight (sorting)', 'flag_sorted' => 1, 'weight' => 240]);
        DB::table('field_types')->insert(['id' => 8, 'name' => 'Field Types (system)', 'code' => 'fieldtypes', 'description' => '', 'flag_system' => 1, 'weight' => 0]);
        DB::table('field_types')->insert(['id' => 9, 'name' => 'Password (system)', 'code' => 'password', 'description' => '', 'flag_system' => 1, 'weight' => 0]);
        DB::table('field_types')->insert(['id' => 10, 'name' => 'Image (public disk)', 'code' => 'imagelocal', 'description' => 'Image in local storage', 'weight' => 230]);
        DB::table('field_types')->insert(['id' => 11, 'name' => 'Image (S3 disk)', 'code' => 'images3', 'description' => '', 'flag_system' => 0, 'weight' => 220]);
        #DB::table('field_types')->insert(['id' => 12, 'name' => 'Data Source (enumerate)', 'code' => 'enumerate', 'flag_sorted' => 0, 'weight' => 230]);
        #DB::table('field_types')->insert(['id' => 13, 'name' => 'Data Source (collections)', 'code' => 'extented_enumerate', 'flag_sorted' => 0, 'weight' => 220]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_types');
    }
}