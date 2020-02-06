<?php

	namespace App\Http\Controllers\crud\fields;

	use App\Http\Controllers\crud\fieldClass;	
	
	class flagFieldClass  extends fieldClass {
		
		public function setFilterWhere ($model, $field,  $value) {
			
			$value = (int) $value;
			
			if ($value == 1) {
			
				$model  = $model->where($field->code, 1);
				
			} else {
			
				$model  = $model->where($field->code, 0);				
				
			}
			
			return $model;
			
		}
		
	}
