<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;
	
	class FieldGroup extends Model {
		
		protected $table = 'field_groups';
		
		public $timestamps = false;
		
		// Relationships
		
		public function tables() {
			
			return $this->hasMany('App\Table', 'menu_group_id')->where('active', 1)->orderBy('weight', 'DESC');
		
		}			
			
	}
