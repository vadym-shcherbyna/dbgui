<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;
	
	class Field extends Model {
		
		protected $table = 'fields';
		
		public $timestamps = false;
		
		// Relationships
		
		public function type () {
			
			return $this->belongsTo('App\FieldGroup', 'field_group_id');
			
		}		
			
	}
