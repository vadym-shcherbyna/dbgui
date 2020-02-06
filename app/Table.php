<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;
	
	class Table extends Model {
		
		protected $table = 'tables';
		
		public $timestamps = false;
		
		// Relationships
		
		public function fieldsView() {
			
			return $this->hasMany('App\Field', 'table_id')->where('flag_view', 1)->orderBy('weight', 'DESC');
		
		}		

		public function filters() {
			
			return $this->hasMany('App\Field', 'table_id')->where('flag_filter', 1)->orderBy('weight', 'DESC');
		
		}						
		
		public function fields() {
			
			return $this->hasMany('App\Field', 'table_id')->orderBy('weight', 'DESC');
		
		}				
			
	}
