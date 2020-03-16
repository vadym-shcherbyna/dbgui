<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('weight')->default(0);
        });

        // Populate
        DB::table('table_groups')->insert(['id' => 1, 'name' => 'Data', 'weight' => 100]);
        DB::table('table_groups')->insert(['id' => 2, 'name' => 'Accounts', 'weight' => 90]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_groups');
    }
}