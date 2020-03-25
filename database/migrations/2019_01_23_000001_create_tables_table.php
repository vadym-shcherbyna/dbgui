<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_group_id');
            $table->foreign('table_group_id')
                ->references('id')->on('table_groups')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('code', 191)->unique();
            $table->string('url');
            $table->integer('weight')->default(0);
            $table->string('item_name')->nullable();
            $table->string('fa')->default('table')->nullable();
            $table->boolean('flag_view')->default(1);
            $table->boolean('flag_system')->default(0);
        });

        // Populate
        DB::table('tables')->insert(['id' => 1, 'table_group_id' => 1, 'name' => 'Tables', 'code' => 'tables', 'url' => 'tables', 'weight' => 100, 'fa' => 'database', 'item_name' => 'table', 'flag_system' => 1]);
        DB::table('tables')->insert(['id' => 2, 'table_group_id' => 1, 'name' => 'Fields',  'code' => 'fields', 'url' => 'fields', 'weight' => 90, 'fa' => 'edit', 'item_name' => 'field', 'flag_system' => 1]);
        DB::table('tables')->insert(['id' => 3, 'table_group_id' => 1, 'name' => 'Field types',  'code' => 'field_types', 'url' => 'field-types', 'weight' => 80, 'fa' => 'table', 'item_name' => 'type', 'flag_system' => 1, 'flag_view' => 0]);
        DB::table('tables')->insert(['id' => 4, 'table_group_id' => 1, 'name' => 'Table groups',  'code' => 'table_groups', 'url' => 'table-groups', 'weight' => 70, 'fa' => 'list-ul', 'item_name' => 'group', 'flag_system' => 1]);
        DB::table('tables')->insert(['id' => 5, 'table_group_id' => 1, 'name' => 'Settings', 'code' => 'settings', 'url' => 'settings', 'weight' => 60, 'fa' => 'cogs', 'item_name' => 'Setting', 'flag_system' => 1]);
        DB::table('tables')->insert(['id' => 6, 'table_group_id' => 2, 'name' => 'Users', 'code' => 'users', 'url' => 'users', 'weight' => 100, 'fa' => 'users', 'item_name' => 'user']);
        DB::table('tables')->insert(['id' => 7, 'table_group_id' => 2, 'name' => 'User groups', 'code' => 'user_groups', 'url' => 'user-groups', 'weight' => 90, 'fa' => 'user', 'item_name' => 'group', 'flag_system' => 1, 'flag_view' => 0]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}