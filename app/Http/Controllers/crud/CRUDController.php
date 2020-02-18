<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\pageController;
use App\Table;
use DB;
use Validator;
use Illuminate\Http\Request;

class CRUDController extends pageController
{
    /**
     * Values  for paginations  -  rows  per  page
     *
     * @var array
     */
    const PAGINATION_ARRAY = [10, 20, 30, 40, 50, 60, 70, 80, 90 ,100];

    /**
     * Flaged value  for clear filters
     *
     * @var array
     */
    const FILTER_CLEAR = 'clear';

    /**
     * Current value  for  rows  per  page
     *
     * @global private
     * @var integer
     */
    private $currentPagination = 10;

    /**
     * Default field for  sorting
     *
     * @global private
     * @var string
     */
    private $sortingField = 'id';

    /**
     * Default direct for sorting ASC|DESC
     *
     * @global private
     * @var string
     */
    private $sortingDirection = 'DESC';

    /**
     * Controller for index page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('crud.pages.index', $this->Data);
    }

    /**
     * Controller for crud/{table_code} - items  list
     *
     * @param  string $tableCode  table code
     * @return Illuminate\View\View|Illuminate\Support\Facades\Redirect
     */
	public function itemsList ($tableCode)
    {
	    // Check table code
		$this->Data['table'] = Table::with('fieldsView')->with('filters')->where('url', $tableCode)->first();
		if ($this->Data['table']) {
		    // Add page number  to  session
            if (request()->has('page')) {
                request()->session()->put('page.'.$this->Data['table']->code, request()->input('page'));
            }

            // Copy page number  from session to   \Illuminate\Http\Request
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
				
            // Apply  filters
			if (request()->session()->has('filters.'.$this->Data['table']->code)) {
			    $filters  = request()->session()->get('filters.'.$this->Data['table']->code);

				foreach($filters as $filter) {
				    $this->Data['items'] = $this->{$this->fieldClass($filter['field'])}->setFilterWhere($this->Data['items'], $filter['field'],  $filter['value']);
				}
            }
				
            // Set Sorting value  to  session
            if (request()->session()->has('sorting.'.$this->Data['table']->code)) {
                $sort = request()->session()->get('sorting.'.$this->Data['table']->code);
                $this->sortingField = $sort['field']->code;
                $this->sortingDirection = $sort['direction'];
            }
				
            // Apply sorting
			$this->Data['items']  = $this->Data['items']->orderBy($this->sortingField, $this->sortingDirection);
				
            // Run SQL QUERY
            $this->Data['items']  = $this->Data['items']->paginate($this->currentPagination);
				
            // Mutate rows  by  Fields Classes
			foreach ($this->Data['items'] as $key => $value) {
			    foreach ($this->Data['table']->fieldsView as $field) {
			        $this->Data['items'][$key]->{$field->code} = $this->{$this->fieldClass($field)}->mutateList($this->Data['items'][$key]->{$field->code}, $field);
			    }
			}
				
			// If $this->Data['items'] is empty -  clear current  pagination  and redirect to pagination first page
			if ($this->Data ['items']->count() == 0 && request()->session()->has('page.'.$this->Data['table']->code)) {
			    $this->forgetPagination();
			    return $this->redirectToList();
			}
				
			// Mutate  filters  by  Fields Classes
            foreach ($this->Data['table']->filters as $key => $filter) {
				$this->Data['table']->filters[$key] = $this->{$this->fieldClass($filter)}->setFilterOptions($filter, $this->Data['table']);
            }

            // Set View's variables
            $this->Data['paginationArray'] = self::PAGINATION_ARRAY;
            $this->Data['currentPagination'] = $this->currentPagination;
			$this->Data['sortingField'] = $this->sortingField;
			$this->Data['sortingDirection'] = $this->sortingDirection;

			if ($this->Data['sortingDirection'] == 'ASC') {
				$this->Data['direction'] = 'desc';
			} else {
				$this->Data['direction'] = 'asc';
			}

			return view('crud.pages.list', $this->Data);
		}
			
	}

    /**
     * Controller for crud/{table}/list/filter/{field}/value/{value} - items  list with filter
     *
     * @param string  $tableCode table code
     * @param string  $fieldID filter ID
     * @param string  $value filter value
     * @return CRUDController
     */
    public function itemsListFilter ($tableCode, $fieldID, $value)
    {
        //  Checking table
        if ($this->checkTable($tableCode)) {
            // Get  table  field by $fieldID
            if ($field = $this->getTableFieldById($fieldID)) {
                if ($value == self::FILTER_CLEAR) {
                    // Delete filter from session
                    request()->session()->forget('filters.'.$this->Data['table']->code.'.'.$fieldID);
                } else {
                    //  Add filter into session
                    request()->session()->put('filters.'.$this->Data['table']->code.'.'.$fieldID, ['field' =>  $field, 'value' => $value]);
                }
            }

			// Clear  pagination if  apply  new filter
			$this->forgetPagination();
				
			return $this->itemsList($tableCode);
        }
    }

    /**
     * Controller for crud/{table}/list/sort/{field}/direction/{value} - items  list with sorting
     *
     * @param string  $tableCode table code
     * @param string  $fieldID sorted field ID
     * @param string  $value sort value  ASC|DESC
     * @return CRUDController
     */
    public function itemsListSorting  ($tableCode, $fieldID, $value)
    {
        //  Checking table
		if ($this->checkTable($tableCode)) {
            // Get  table  field by $fieldID
            if ($field = $this->getTableFieldById($fieldID)) {
                $direction = ($value == 'desc') ? 'DESC' : 'ASC';

                // Save  sorting  in  session
                request()->session()->put('sorting.'.$this->Data['table']->code, ['field' =>  $field, 'direction' => $direction]);
            }
				
			return $this->itemsList($tableCode);
		}
    }

    /**
     * Controller for crud/{table}/flag/{field}/id/{id} - change  value of  flag
     *
     * @param string  $tableCode table code
     * @param string  $fieldID field ID
     * @param string  $id row  ID
     * @return CRUDController
     */
    public function itemsListFlag ($tableCode, $fieldID, $id)
    {
        //  Checking table
        if ($this->checkTable($tableCode)) {
            // Get  table  field by $fieldID
            if ($field = $this->getTableFieldById($fieldID)) {
                // Get row
				$row = DB::table($this->Data['table']->code)->where('id', $id)->first();

				if ($row)  {
                    // Check value of flag
                    if ($row->{$field->code}) {
                        //  Set  flag field  to 0
                        $row = DB::table($this->Data['table']->code)->where('id', $id)->update([$field->code => 0]);
                    } else {
                        //  Set  flag field  to 1
                        $row = DB::table($this->Data['table']->code)->where('id', $id)->update([$field->code => 1]);
                    }
                }
            }
				
			return $this->itemsList($tableCode);
        }
			
	}

    /**
     * Controller for crud/{table_code}/add GET show  form
     *
     * @param string  $tableCode table code
     * @return Illuminate\View\View
     */
	public function itemAddGet ($tableCode)
    {
        // Check table
        if ($this->checkTable($tableCode)) {
            // Mutate fields
            foreach ($this->Data['table']->fields as $key => $field) {
                $this->Data['table']->fields[$key] = $this->{$this->fieldClass($field)}->mutateAddGet($field);
            }
					
			return view('crud.pages.add', $this->Data);
        }
    }

    /**
     * Controller for crud/{table_code}/add POST process  POST  form
     *
     * @param  \Illuminate\Http\Request $request
     * @param string  $tableCode table code
     * @return Illuminate\View\View
     */
    public function itemAddPost (Request $request, $tableCode)
    {
        // Check table and row
        if ($this->checkTable($tableCode)) {
            // Validate
            $validator = Validator::make($request->all(), $this->validateArray($this->Data['table']->fields));
				
            // return form if  error
            if ($validator->fails()) {
                return redirect('crud/'.$this->Data['table']->url.'/add')
                    ->withErrors($validator)
                    ->withInput();
            }
				
			// Mutate POST data	 By Fields Classes
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

    /**
     * Controller for crud/{table_code}/edit/{id} GET:  show  edit form
     *
     * @param string  $tableCode table code
     * @param integer  $id row ID
     * @return Illuminate\View\View
     */
    public function itemEditGet ($tableCode, $id)
    {
        // Check table  by  code
        if ($this->checkTable($tableCode)) {
            // Check row  by  ID
            if ($this->checkRow($id)) {
                // Mutate fields
                foreach ($this->Data['table']->fields as $key => $field) {
                    $this->Data['table']->fields[$key] = $this->{$this->fieldClass($field)}->mutateEditGet($field);
                }

                return view('crud.pages.edit', $this->Data);
            }
        }
    }

    /**
     * Controller for crud/{table_code}/edit/{id} POST:  proccess edit form
     *
     * @param  \Illuminate\Http\Request $request
     * @param string  $tableCode table code
     * @param integer  $id row ID
     * @return Illuminate\View\View
     */
	public function itemEditPost (Request $request, $tableCode, $id)
    {
        // Check table  by  code
        if ($this->checkTable($tableCode)) {
            // Check row  by  ID
            if ($this->checkRow($id)) {
                // Validate
                $validator = Validator::make($request->all(), $this->validateArray($this->Data['table']->fields));

                // return form
                if ($validator->fails()) {
                    return redirect('crud/' . $this->Data['table']->url . '/edit/' . $this->Data['row']->id)
                        ->withErrors($validator)
                        ->withInput();
                }

                // Mutate POST data
                $updateArray = [];
                foreach ($this->Data['table']->fields as $key => $field) {
                    $updateArray [$field->code] = $this->{$this->fieldClass($field)}->mutateEditPost($request, $field);
                }

                // Get  old Row  data
                $rowModel = DB::table($this->Data['table']->code)->where('id', $id)->first();

                // Update  row
                DB::table($this->Data['table']->code)->where('id', $id)->update($updateArray);

                // Extra
                $this->itemEditPostMutate($rowModel, $updateArray);

                return $this->redirectToList();
            }
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

    /**
     * Return  table field  by  ID
     *
     * @param int  $fieldId table field ID
     * @return array
     */
    protected function getTableFieldById ($id)
    {
        foreach ($this->Data['table']->fields as $key => $field) {
            if ($field->id == $id) {
                return $field;
            }
        }

        return false;
    }

    /**
     * Set current  table by table code
     *
     * @param string  $tableCode table code  (SLUG)
     * @return boolean
     */
    protected function checkTable($tableCode)
    {
        //  Get  table   by code
        $tableModel = Table::with('fields')->where('url', $tableCode)->first();

        if ($tableModel) {
            $this->Data['table'] = $tableModel;

            return true;
        }
			
        return false;
			
    }

    /**
     * Set current  row by row ID
     *
     * @param int  $id row ID
     * @return boolean
     */
    protected function checkRow($id)
    {
    	// Check row
        $row = DB::table($this->Data['table']->code)->where('id', $id)->first();
        if ($row) {
            $this->Data['row'] = $row;
					
            return true;
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
