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
            $table->boolean('flag_sorted')->default(1);
        });

        // Populate
        DB::table('field_types')->insert(['id' => 1, 'name' => 'Short Text', 'code' => 'varchar', 'flag_sorted' => 1]);
        DB::table('field_types')->insert(['id' => 2, 'name' => 'Checkbox', 'code' => 'flag', 'flag_sorted' => 0]);
        DB::table('field_types')->insert(['id' => 3, 'name' => 'Integer', 'code' => 'integer', 'flag_sorted' => 1]);
        DB::table('field_types')->insert(['id' => 4, 'name' => 'Long Text', 'code' => 'text']);
        DB::table('field_types')->insert(['id' => 5, 'name' => 'Date and Time', 'code' => 'datetime', 'flag_sorted' => 1]);
        DB::table('field_types')->insert(['id' => 6, 'name' => 'Data Source (tables)', 'code' => 'tables', 'flag_sorted' => 0]);
        DB::table('field_types')->insert(['id' => 7, 'name' => 'Weight (sorting)', 'code' => 'weight', 'flag_sorted' => 1]);
        #DB::table('field_types')->insert(['id' => 8, 'name' => 'Data Source (enumerate)', 'code' => 'enumerate', 'flag_sorted' => 0]);
        #DB::table('field_types')->insert(['id' => 8, 'name' => 'Data Source (reference)', 'code' => 'extented_enumerate', 'flag_sorted' => 0]);
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