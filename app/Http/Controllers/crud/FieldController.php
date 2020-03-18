<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use Illuminate\Http\Request;
use App\FieldType;
use App\Table;
use App\Rules\FieldCode;

class FieldController extends CRUDController
{
    /**
     * table Id
     *
     * @global private
     * @var integer
     */
    private $tableId = 0;

    /**
     * Call itemAddPost with code 'fields'
     *
     * @param  \Illuminate\Http\Request $request
     * @return CRUDController
     */
    public function fieldAddPost (Request $request)
    {
        $this->tableId  = $request->table_id;
        
        return parent::itemAddPost ($request, 'fields');
    }

    /**
     * Action after insert row data
     *
     * @param array  $insertData row data after insert
     * @return void
     */
    protected function itemAddPostMutate ($insertData)
    {
        // Get field  type
        $fieldType = FieldType::where('id', $insertData ['field_type_id'])->first();

        // Get table data
        $table = Table::where('id', $insertData ['table_id'])->first();

        //  Call Field class method  fir creating field
        $this->{$this->fieldClassByType($fieldType)}->createFields($insertData, $table);
    }

    /**
     * Action after update row data
     *
     * @param array  $updateData post data  for updating
     * @param array  $dbData row data from database
     * @return void
     */
    protected function itemEditPostMutate ($updateData, $dbData)
    {
        
    }

    /**
     * Action after delete row data
     *
     * @param array  $rowData deleting row data
     * @return void
     */
    protected function itemDeleteMutate ($rowData)
    {
        
    }

    /**
     * Create array with validate rules
     *
     * @param array  $fields table  fields  array
     * @return array
     */
    protected function createValidateArray ($fields, $id = null)
    {
        // Add rule for fieldcode
        $this->validateArray ['code'][] = new FieldCode($this->tableId);

        // Call main func
        parent::createValidateArray($fields, $id);
    }
}
