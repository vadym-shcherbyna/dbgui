<?php

	namespace App\Http\Controllers\crud;

	use App\Http\Controllers\pageController;	
	
	use App\Table;
	
	use DB;
	use Validator;
	use Illuminate\Http\Request;

	class CRUDController extends pageController {
		
		private $paginationArray = [10, 20, 30, 40, 50, 60, 70, 80, 90 ,100];
		
		private $currentPagination = 10;
		
		private $sortingField = 'id';
		
		private $sortingDirection = 'DESC';
		
		//
		
		public function index() { 
						
			return view('crud.pages.index', $this->Data);
			
		}		
		
		// crud/{table_code}
		
		public function itemsList ($tableCode) {	
			
			// Check table
			
			$this->Data['table'] = Table::with('fieldsView')->with('filters')->where('url', $tableCode)->first();
			
			if ($this->Data['table']) {
				
				// Pagination
				
				if (request()->has('page')) {
					
					request()->session()->put('page.'.$this->Data['table']->code, request()->input('page'));
					
				}	

				if (request()->session()->has('page.'.$this->Data['table']->code)) {		
					
					request()->request->add(['page' => request()->session()->get('page.'.$this->Data['table']->code)]);				
					
				}				
			
				// Set title
			
				$this->Data ['title'] = $this->Data['table']->name;
				
				// Set fields
				
				$selectedArray = $this->Data['table']->fieldsView->pluck('code')->toArray();
				
				// Add 'id' element to array
				
				array_unshift($selectedArray, 'id');								
				
				// Creating SQL request
				
				// Main SQL selected fields
				
				$this->Data['items'] = DB::table($this->Data['table']->code)->select($selectedArray);
				
				// Set Filters
				
				if (request()->session()->has('filters.'.$this->Data['table']->code)) {
					
					$filters  = request()->session()->get('filters.'.$this->Data['table']->code);
					
					foreach($filters as $filter) {
											
						$this->Data['items'] = $this->{$this->fieldClass($filter['field'])}->setFilterWhere($this->Data['items'], $filter['field'],  $filter['value']);					
						
					}
					
				}					
				
				// Set Sorting
				
				if (request()->session()->has('sorting.'.$this->Data['table']->code)) {
					
					$sort = request()->session()->get('sorting.'.$this->Data['table']->code);
					
					$this->sortingField = $sort['field']->code;
		
					$this->sortingDirection = $sort['direction'];					
					
				}				
				
				//Sorting
				
				$this->Data['items']  = $this->Data['items']->orderBy($this->sortingField, $this->sortingDirection);	
				
				//  Run
				
				$this->Data['items']  = $this->Data['items']->paginate($this->currentPagination);	
				
				// Mutate rows
				
				foreach ($this->Data['items'] as $key => $value) {
					
					foreach ($this->Data['table']->fieldsView as $field) {
					
						$this->Data['items'][$key]->{$field->code} = $this->{$this->fieldClass($field)}->mutateList($this->Data['items'][$key]->{$field->code}, $field);						
					
					}
					
				}
				
				// Check num rows  and  paginate
				
				if ($this->Data ['items']->count() == 0 && request()->session()->has('page.'.$this->Data['table']->code)) {
					
					$this->forgetPagination();					
					
					return $this->redirectToList();	
					
				}
				
				// Mutate  filters
				
				foreach ($this->Data['table']->filters as $key => $filter) {
					
					$this->Data['table']->filters[$key] = $this->{$this->fieldClass($filter)}->setFilterOptions($filter, $this->Data['table']);
					
				}	

				// Set variables
				
				$this->Data['paginationArray'] = $this->paginationArray;
				
				$this->Data['currentPagination'] = $this->currentPagination;
				
				$this->Data['sortingField'] = $this->sortingField;
				
				$this->Data['sortingDirection'] = $this->sortingDirection;		
				
				//
				
				if ($this->Data['sortingDirection'] == 'ASC') { 				
				
					$this->Data['direction'] = 'desc';
					
				}
				else {
					
					$this->Data['direction'] = 'asc';
					
				}
				
				// view
			
				return view('crud.pages.list', $this->Data);
				
			}
			
		}			
		
		// crud/{table}/pagination/{value}
		
		public function itemsListPagination ($tableCode, $value) {
			
			if ($this->checkTable($tableCode)) {
					
				$this->currentPagination = (int) $value;
				
				// 
				
				$this->forgetPagination();
				
				return $this->itemsList($tableCode);	
				
			}
		}
		
		//  crud/{table}/list/filter/{field}/value/{value}
		
		public function itemsListFilter ($tableCode, $fieldID, $value) {
			
			//  Checking table
			
			if ($this->checkTable($tableCode)) {
					
				// foreach  	fields  and find  filter															
					
				foreach ($this->Data['table']->fields as $key => $field) {
					
					if ($field->id == $fieldID) {
						
						if ($value == 'clear') {
							
							// Delete filter from session
							
							request()->session()->forget('filters.'.$this->Data['table']->code.'.'.$fieldID);
							
						} else {
							
							//  Add filter into session
												
							request()->session()->put('filters.'.$this->Data['table']->code.'.'.$fieldID, ['field' =>  $field, 'value' => $value]);
							
						}
							
					}
					
				}
				
				$this->forgetPagination();
				
				return $this->itemsList($tableCode);
				
			}
			
		}
		
		//  crud/{table}/list/sort/{field}/direction/{value}
		
		public function itemsListSorting  ($tableCode, $fieldID, $value) {
			
			//  Checking table
			
			if ($this->checkTable($tableCode)) {
					
				// foreach  	fields  and find  filter
					
				foreach ($this->Data['table']->fields as $key => $field) {
					
					if ($field->id == $fieldID) {
												
						$direction = 'ASC';
						
						if ($value == 'desc') $direction = 'DESC';
												
						request()->session()->put('sorting.'.$this->Data['table']->code, ['field' =>  $field, 'direction' => $direction]);							
							
					}
					
				}
				
				return $this->itemsList($tableCode);
				
			}
			
		}	

		//  crud/{table}/flag/{field}/id/{id}
		
		public function itemsListFlag ($tableCode, $fieldID, $id) {
			
			//  Checking table
			
			if ($this->checkTable($tableCode)) {
					
				// foreach  	fields  and find  filter
					
				foreach ($this->Data['table']->fields as $key => $field) {
					
					if ($field->id == $fieldID) {
						
						// Get row
						
						$row = DB::table($this->Data['table']->code)->where('id', $id)->first();
						
						// Check value of flag
						
						if ($row->{$field->code}) {
							
							//  Set  flag field  to 1
							
							$row = DB::table($this->Data['table']->code)->where('id', $id)->update([$field->code => 0]);
							
						}
						else {
							
							//  Set  flag field  to 1
							
							$row = DB::table($this->Data['table']->code)->where('id', $id)->update([$field->code => 1]);
							
						}
							
					}
					
				}
				
				return $this->itemsList($tableCode);
				
			}
			
		}			
		
		// crud/{table_code}/add GET
		
		public function itemAddGet ($tableCode) {
			
			// Check table 
			
			if ($this->checkTable($tableCode)) {
				
				// Mutate fields
				
				foreach ($this->Data['table']->fields as $key => $field) {
					
					$this->Data['table']->fields[$key] = $this->{$this->fieldClass($field)}->mutateAddGet($field);
					
				}
					
				return view('crud.pages.add', $this->Data);	
					
			}
			
		}			
		
		// crud/{table_code}/add POST
		
		public function itemAddPost (Request $request, $tableCode) {
			
			// Check table and row
			
			if ($this->checkTable($tableCode)) {
								
				// Validate					
								
				$validator = Validator::make($request->all(), $this->validateArray($this->Data['table']->fields));
				
				// return form

				if ($validator->fails()) {
					
					return redirect('crud/'.$this->Data['table']->url.'/add')
                        ->withErrors($validator)
                        ->withInput();
						
				}
				
				// Mutate POST data
				
				$insertArray = [];
				
				foreach ($this->Data['table']->fields as $key => $field) {
					
					$insertArray [$field->code] = $this->{$this->fieldClass($field)}->mutateAddPost($request, $field);
					
				}
				
				//  Insert row
				
				DB::table($this->Data['table']->code)->insert($insertArray);
				
				// Call extra func.
				
				$this->itemAddPostMutate($insertArray['code']);
				
				// Redirect  to items list
				
				return $this->redirectToList();
					
			}		
			
		}		
		
		// crud/{table_code}/edit/{id} GET
		
		public function itemEditGet ($tableCode, $id) {
			
			// Check table and row
			
			if ($this->checkTableAndRow($tableCode, $id)) {
				
				// Mutate fields
				
				foreach ($this->Data['table']->fields as $key => $field) {
				
					$this->Data['table']->fields[$key] = $this->{$this->fieldClass($field)}->mutateEditGet($field);
					
				}
					
				return view('crud.pages.edit', $this->Data);	
					
			}
			
		}
		
		// crud/{table_code}/edit/{id} POST
		
		public function itemEditPost (Request $request, $tableCode, $id) {
			
			// Check table and row
			
			if ($this->checkTableAndRow($tableCode, $id)) {
								
				// Validate					
								
				$validator = Validator::make($request->all(), $this->validateArray($this->Data['table']->fields));
				
				// return form

				if ($validator->fails()) {
					
					return redirect('crud/'.$this->Data['table']->url.'/edit/'.$this->Data['row']->id)
                        ->withErrors($validator)
                        ->withInput();
						
				}
				
				// Mutate POST data
				
				$updateArray = [];
				
				foreach ($this->Data['table']->fields as $key => $field) {
					
					$updateArray [$field->code] = $this->{$this->fieldClass($field)}->mutateEditPost($request, $field);
					
				}
				
				$rowModel = DB::table($this->Data['table']->code)->where('id', $id)->first();
				
				DB::table($this->Data['table']->code)->where('id', $id)->update($updateArray);
				
				$this->itemEditPostMutate($rowModel->code, $updateArray['code']);
				
				return $this->redirectToList();
					
			}		
			
		}
		
		// crud/{table}/delete/{id} GET
		
		public function itemDelete ($tableCode, $id) {
			
			// Check table and row
			
			if ($this->checkTableAndRow($tableCode, $id)) {
				
				foreach ($this->Data['table']->fields as $key => $field) {
					
					$this->{$this->fieldClass($field)}->mutateDelete($this->Data['row'], $field);
					
				}
				
				$row = DB::table($this->Data['table']->code)->where('id', $id)->first();
				
				DB::table($this->Data['table']->code)->where('id', $id)->delete();
				
				$this->itemDeleteMutate($row->code);
					
			}		
			
			return $this->redirectToList();
			
		}		
		
		//		
		// Internal protected system function - not accessable for controllers		
		//
		
		protected function checkTable($tableCode) {
			
			$tableModel = Table::with('fields')->where('url', $tableCode)->first();
			
			if ($tableModel) {
				
				$this->Data['table'] = $tableModel;
				
				return true;
				
			}
			
			return false;
			
		}
		
		//
		
		protected function checkTableAndRow($tableCode, $id) {

			// Check table
			
			if ($this->checkTable($tableCode))  {
				
				// Check row
				
				$row = DB::table($this->Data['table']->code)->where('id', $id)->first();	
				
				if ($row) {
					
					$this->Data['row'] = $row;		
					
					return true;
					
				}
				
			}
			
			return false;
			
		}
		
		// Create validate array
		
		protected function validateArray ($fields) {
			
			$validateArray = [];
			
			foreach ($fields as $key => $value) {
					
				// implement require flag
					
				if ($value->flag_required) {
					
					$validateArray [$value->code] = 'required'; 
						
				}				
				
				// implement unique flag
				
				/*
				
				if ($value->flag_unique) {
					
					$validateArray [$value->code] .= '|unique:'.$this->DATA ['CurrentTable']->code.','.$value->code; 
					
					if ($id) {
						
						$validateArray [$value->code] .= ','.$id;
						
					}
						
				}	
				
				*/				
					
			}			
			
			return $validateArray;
			
		}			
		
		// Redirect to List of  items
		
		protected function redirectToList () {
				
			return redirect('crud/'.$this->Data['table']->url);			
				
		}		
		
		// Forget pagination
		
		protected function forgetPagination () {
			
			request()->session()->forget('page.'.$this->Data['table']->code);
			
		}
		
		//  Function for tables and fields
		
		protected function itemAddPostMutate ($insertArray) {
		
			return true;
		
		}		
		
		protected function itemEditPostMutate ($from,$to) {
		
			return true;
		
		}					

		protected function itemDeleteMutate ($row) {
		
			return true;
		
		}							
		
	}
