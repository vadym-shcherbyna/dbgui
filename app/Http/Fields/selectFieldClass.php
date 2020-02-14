<?php

	namespace App\Http\Fields;

	use App\Http\Fields\fieldClass;	
	
	use App\Table;
	
	use DB;
	use Validator;
	use Illuminate\Http\Request;	
	
	class selectFieldClass  extends fieldClass {
		
		private $options = [];
		
		public function mutateAddGet ($field) {
			
			return $this->mutateEditGet ($field);
		
		}		
		
		public function mutateList ($value, $field) {
			
			//
			
			$options = [];
			
			// Get options from array OR from DB
			
			if (isset($this->options[$field->code]))  {
				
				$options = $this->options[$field->code];
				
			}
			else {
			
				$linkedTable = Table::find($field->linked_table_id);
			
				if ($linkedTable) {
			
					$this->options[$field->code] = DB::table($linkedTable->code)->orderBy('id', 'ASC')->get();
				
				}			
				
			}
			
			// Mutate value
			
			foreach ($this->options[$field->code] as $option) {
				
				if ($value == $option->id) {
					
					$value = $option->name;
					
				}
				
			}
			
			return $value;
		
		}		
		
		public function mutateEditGet ($field) {
			
			$linkedTable = Table::find($field->linked_table_id);
			
			if ($linkedTable) {
			
				$field->options = DB::table($linkedTable->code)->select('id', 'name')->orderBy('id', 'ASC')->get();
				
			}
			
			return $field;
		
		}						
		
		public function setFilterOptions ($field, $table) {
			
			$field->options  =  [];
			
			//
			
			if (isset($this->options[$field->code]))  {
				
				$field->options =  $this->options[$field->code];
				
			}
			else {
				
				$linkedTable = Table::find($field->linked_table_id);
			
				if ($linkedTable) {
			
					$field->options = DB::table($linkedTable->code)->select('id', 'name')->orderBy('name', 'ASC')->get();
				
				}
				
			}
			
			//
			
			if (request()->session()->has('filters.'.$table->code)) {
				
				$filters = request()->session()->get('filters.'.$table->code);
				
				if  (isset($filters[$field->id])) {
				
					$field->value = $filters [$field->id] ['value'];
					
				}
				
			}
			
			return $field;
		
		}		
		
	}
