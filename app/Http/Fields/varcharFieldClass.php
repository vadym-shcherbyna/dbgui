<?php

	namespace App\Http\Fields;

	use App\Http\Fields\fieldClass;	
	
	class varcharFieldClass  extends fieldClass {

		public function setFilterWhere ($model, $field,  $value) {
		
			$model  = $model->where($field->code, 'LIKE', '%'.$value.'%');
			
			return $model;
		
		}			
		
	}
