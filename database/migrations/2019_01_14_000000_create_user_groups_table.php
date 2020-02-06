<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateUserGroupsTable extends Migration {
		
		public function up() {
			
			Schema::create('user_groups', function (Blueprint $table) {
				
				$table->increments('id');
				
				$table->string('name');
				
			});
			
			// Populate
			
			DB::table('user_groups')->insert(['id' => 1, 'name' => 'Administrators']);			
			
			DB::table('user_groups')->insert(['id' => 2, 'name' => 'Moderators']);			
			
			DB::table('user_groups')->insert(['id' => 3, 'name' => 'Users']);						
			
		}
		
		public function down() {
			
			Schema::dropIfExists('user_groups');
			
		}
		
	}