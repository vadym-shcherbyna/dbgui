<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;
	
	class TableGroup extends Model {
		
		protected $table = 'table_groups';
		
		public $timestamps = false;
		
		// Relationships
		
		public function tables() {
			
			return $this->hasMany('App\Table', 'table_group_id')->orderBy('weight', 'DESC');
		
		}			
			
	}
