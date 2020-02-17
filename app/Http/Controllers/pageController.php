<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TableGroup;
use App\FieldGroup;

class pageController extends Controller
{
		
	public $Data = [];
		
	public function __construct() {
			
			//
			$this->Data ['table_groups'] = TableGroup::with('tables')->orderBy('weight', 'DESC')->get();
			
			//
			$fieldGroups = FieldGroup::orderBy('name', 'ASC')->get();
			
			// Init all field's classes (types)
			foreach ($fieldGroups as $field) {
				$fieldName = $field->code.'FieldClass';
				$fieldClass = 'App\Http\Fields\\'.$field->code.'FieldClass';
				$this->$fieldName = new $fieldClass;
			}			
			
			//
			$this->Data['table'] = new \stdClass;
			$this->Data['table']->table_group_id = 0;
			$this->Data['table']->code = '';			
				
		}	
		
		public function fieldClass ($field) {
			$fieldClass = $field->type->code.'FieldClass';
			return $fieldClass;
		}		
		
	}
