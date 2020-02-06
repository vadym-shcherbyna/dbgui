<?php

	namespace App\Http\Controllers\crud;

	use App\Http\Controllers\crud\CRUDController;	
	
	use App\Table;

	class FieldController extends CRUDController {
		
		protected function itemAddPostMutate ($insertArray) {
		
			return true;
		
		}		
		
		protected function itemEditPostMutate () {
		
			return true;
		
		}					

		protected function itemDeleteMutate () {
		
			return true;
		
		}	
		
	}
