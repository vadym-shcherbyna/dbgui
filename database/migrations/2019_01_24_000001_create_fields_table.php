<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_type_id');
            $table->unsignedBigInteger('linked_data_id')->default(0);
            $table->unsignedBigInteger('table_id');
            $table->string('name');
            $table->string('code');
            $table->integer('weight')->default(0)->nullable();
            $table->boolean('flag_view')->default(0);
            $table->boolean('flag_edit')->default(1);
            $table->boolean('flag_required')->default(0);
            $table->boolean('flag_filter')->default(0);
            $table->boolean('flag_unique')->default(0);
            $table->string('default_value')->nullable();
            $table->foreign('field_type_id')
                ->references('id')->on('field_types')
                ->onDelete('cascade');
            $table->foreign('table_id')
                ->references('id')->on('tables')
                ->onDelete('cascade');
        });

        // Populate
        // Table groups fields
        DB::table('fields')->insert(['table_id' => 4, 'field_type_id' => 7, 'name' => 'Weight', 'code' => 'weight', 'weight' => 100, 'flag_required' => 1, 'flag_view' => 1, 'default_value' => 100]);
        DB::table('fields')->insert(['table_id' => 4, 'field_type_id' => 1, 'name' => 'Name', 'code' => 'name', 'weight' => 90, 'flag_required' => 1, 'flag_view' => 1]);

        // Table fields
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 7, 'name' => 'Weight', 'code' => 'weight', 'weight' => 130, 'flag_required' => 1, 'flag_view' => 1, 'default_value' => 100]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 6, 'name' => 'Menu group', 'code' => 'table_group_id', 'weight' => 120, 'flag_required' => 1, 'flag_filter' => 1, 'linked_data_id' => 4]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 1, 'name' => 'Name', 'code' => 'name', 'weight' => 110, 'flag_required' => 1, 'flag_view' => 1]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 1, 'name' => 'Code', 'code' => 'code', 'weight' => 100, 'flag_required' => 1, 'flag_view' => 1, 'flag_unique'  => 1]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 1, 'name' => 'Url', 'code' => 'url', 'weight' => 90, 'flag_required' => 1, 'flag_view' => 1]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 1, 'name' => 'Item name', 'code' => 'item_name', 'weight' => 80]);
        DB::table('fields')->insert(['table_id' => 1, 'field_type_id' => 1, 'name' => 'FA Icon', 'code' => 'fa', 'weight' => 70,  'default_value' =>  'table']);

        // Field types fields
        DB::table('fields')->insert(['table_id' => 3, 'field_type_id' => 1, 'name' => 'Name', 'code' => 'name', 'weight' => 100, 'flag_required' => 1, 'flag_view' => 1]);
        DB::table('fields')->insert(['table_id' => 3, 'field_type_id' => 1, 'name' => 'Code', 'code' => 'code', 'weight' => 90, 'flag_required' => 1, 'flag_view' => 1]);
        DB::table('fields')->insert(['table_id' => 3, 'field_type_id' => 1, 'name' => 'Description', 'code' => 'description', 'weight' => 80, 'flag_view' => 1]);

        // Fields fields
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 7, 'name' => 'Weight', 'code' => 'weight', 'weight' => 110, 'flag_required' => 1, 'flag_view' => 1, 'default_value' => 100]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 6, 'name' => 'Table', 'code' => 'table_id', 'weight' => 100, 'flag_required' => 1, 'flag_filter' => 1, 'linked_data_id' => 1, 'flag_view' => 1, 'flag_edit' => 0]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 8, 'name' => 'Field type', 'code' => 'field_type_id', 'weight' => 90, 'flag_required' => 1, 'linked_data_id' => 3, 'flag_edit' => 0]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 1, 'name' => 'Name', 'code' => 'name', 'weight' => 80, 'flag_required' => 1, 'flag_view' => 1, 'flag_filter' => 1]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 1, 'name' => 'Code', 'code' => 'code', 'weight' => 70, 'flag_required' => 1, 'flag_view' => 1]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 2, 'name' => 'Required', 'code' => 'flag_required', 'weight' => 60, 'default_value' => 1]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 2, 'name' => 'Unique', 'code' => 'flag_unique', 'weight' => 50]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 2, 'name' => 'View', 'code' => 'flag_view', 'weight' => 40, 'flag_view' => 1, 'flag_filter' => 1, 'default_value' => 1]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 2, 'name' => 'Edit', 'code' => 'flag_edit', 'weight' => 30, 'flag_view' => 1, 'default_value' => 1]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 2, 'name' => 'Filter', 'code' => 'flag_filter', 'weight' => 20]);
        DB::table('fields')->insert(['table_id' => 2, 'field_type_id' => 1, 'name' => 'Defaul value', 'code' => 'default_value', 'weight' => 10]);

        // User groups fields
        DB::table('fields')->insert(['table_id' => 6, 'field_type_id' => 1, 'name' => 'Name', 'code' => 'name', 'weight' => 100, 'flag_required' => 1, 'flag_view' => 1]);

        // User fields
        DB::table('fields')->insert(['table_id' => 5, 'field_type_id' => 5, 'name' => 'Created', 'code' => 'created_at', 'weight' => 110, 'flag_required' => 1, 'flag_view' => 1, 'flag_edit' => 0]);
        DB::table('fields')->insert(['table_id' => 5, 'field_type_id' => 1, 'name' => 'Email', 'code' => 'email', 'weight' => 90, 'flag_required' => 1, 'flag_view' => 1, 'flag_edit' => 0]);
        DB::table('fields')->insert(['table_id' => 5, 'field_type_id' => 6, 'name' => 'User group', 'code' => 'user_group_id', 'weight' => 80, 'flag_required' => 1, 'linked_data_id' => 6, 'flag_view' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}