<?php

	namespace App\Http\Fields;

	use Illuminate\Http\Request;
	
	class fieldClass  {
		
		public $isSorted = true;

		public function mutateAddGet ($field) {
			return $field;
		}		
		
		public function mutateList ($value, $field) {
			return $value;
		}					
		
		public function mutateAddPost (Request $request, $field) {
			return $request->input($field->code);
		}			
		
		public function mutateEditGet ($field) {
			return $field;
		}		
		
		public function mutateEditPost (Request $request, $field) {
			return $request->input($field->code);
		}				
		
		public function mutateDelete ($row, $field) {
			return $row->{$field->code};
		}		

		public function setFilterWhere ($model, $field,  $value) {
			$model  = $model->where($field->code, $value);

			return $model;
		}	

		public function setFilterOptions ($field, $table) {
			
			$field->options  = [];
			
			if (request()->session()->has('filters.'.$table->code)) {

				$filters = request()->session()->get('filters.'.$table->code);

				if  (isset($filters[$field->id])) {
					$field->value = $filters [$field->id] ['value'];
				}
				
			}
			
			return $field;
		
		}			
		
	}
