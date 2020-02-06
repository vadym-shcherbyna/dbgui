<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateFieldGroupsTable extends Migration {
		
		public function up() {
			
			Schema::create('field_groups', function (Blueprint $table) {
				
				$table->increments('id');				
				
				$table->string('name');
				
				$table->string('code');
				
				$table->boolean('flag_sorted')->default(1);
				
			});
			
			// Populate
			
			DB::table('field_groups')->insert(['id' => 1, 'name' => 'Varchar', 'code' => 'varchar', 'flag_sorted' => 1]);			
			
			DB::table('field_groups')->insert(['id' => 2, 'name' => 'Flag', 'code' => 'flag', 'flag_sorted' => 0]);			
			
			DB::table('field_groups')->insert(['id' => 3, 'name' => 'Integer', 'code' => 'integer', 'flag_sorted' => 1]);			
			
			DB::table('field_groups')->insert(['id' => 4, 'name' => 'Text', 'code' => 'text']);	
			
			DB::table('field_groups')->insert(['id' => 5, 'name' => 'Timestamp', 'code' => 'timestamp', 'flag_sorted' => 1]);	
			
			DB::table('field_groups')->insert(['id' => 6, 'name' => 'Select', 'code' => 'select', 'flag_sorted' => 0]);	
			
			
		}
		
		public function down() {
			
			Schema::dropIfExists('field_groups');
			
		}
		
	}