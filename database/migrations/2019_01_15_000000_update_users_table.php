<?php

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class UpdateUsersTable extends Migration {
		
		public function up() {
			
			Schema::table('users', function (Blueprint $table) {
				
				$table->unsignedInteger('user_group_id')->default(3);			
				
				$table->foreign('user_group_id')
					->references('id')->on('user_groups')
					->onDelete('cascade');		

			});
			
		}
		
		public function down() {
			
			Schema::table('users', function (Blueprint $table) {
				
				//
			
			});
			
		}
		
	}