<?php

	namespace App\Http\Controllers\crud\fields;

	use App\Http\Controllers\crud\fieldClass;
	
	class varcharFieldClass  extends fieldClass {

		public function setFilterWhere ($model, $field,  $value) {
		
			$model  = $model->where($field->code, 'LIKE', '%'.$value.'%');
			
			return $model;
		
		}			
		
	}
