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
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('weight')->default(0);
            $table->boolean('flag_system')->default(0);
        });

        // Populate
        DB::table('table_groups')->insert(['id' => 1, 'name' => 'System', 'code' => 'system', 'weight' => 100, 'flag_system' => 1]);
        DB::table('table_groups')->insert(['id' => 2, 'name' => 'Accounts', 'code' => 'accounts', 'weight' => 90, 'flag_system' => 1]);
        DB::table('table_groups')->insert(['id' => 3, 'name' => 'Data', 'code' => 'data', 'weight' => 110, 'flag_system' => 0]);
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