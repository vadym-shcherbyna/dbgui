<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;

class TableController extends CRUDController
{
		// ADD
		
		public function itemAddPost (Request $request,  $tableCode = 'tables') {	
		
			return parent::itemAddPost ($request, 'tables');
		
		}
			
		protected function itemAddPostMutate ($code) {
		
			Schema::create($code, function (Blueprint $table) {
				
				$table->increments('id');
				
			});
		
		}		
		
		//  EDIT
		
		public function itemEditPost (Request $request, $id, $tableCode = 'tables') {
			
			return parent::itemAddPost ($request, 'tables', $id);
		
		}	
		
		protected function itemEditPostMutate ($rowModel, $updateArray) {
		
			Schema::rename($rowModel->code, $updateArray->code);
		
		}					
		
		// DELETE
		
		public function itemDelete ($id, $tableCode = 'tables') {	
		
			return parent::itemDelete ('tables',  $id);
		
		}				

		protected function itemDeleteMutate ($code) {
			
			Schema::dropIfExists($code);			
		
		}		
		
	}
