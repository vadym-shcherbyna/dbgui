<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use Illuminate\Http\Request;
use App\FieldType;
use App\Table;
use App\Field;
use App\Rules\ColumnExists;
use App\Rules\ColumnName;

class FieldController extends CRUDController
{
    /**
     * Call itemAddPost with code 'fields'
     *
     * @param  \Illuminate\Http\Request $request
     * @return CRUDController
     */
    public function fieldAddPost (Request $request)
    {
        return parent::itemAddPost ($request, 'fields');
    }

    /**
     * Action after insert row data
     *
     * @param  array $insertArray
     * @return void
     */
    protected function itemAddPostMutate ($insertArray)
    {
        // Get field  type
        $fieldTypeModel = FieldType::where('id', $insertArray ['field_type_id'])->first();

        // Get table data
        $tableModel = Table::where('id', $insertArray ['table_id'])->first();

        //  Call Field class method  fir creating field
        $this->{$this->fieldClassByType($fieldTypeModel)}->createFields($insertArray, $tableModel);
    }

    /**
     * Call itemEditPost with code 'tables'
     *
     * @param  \Illuminate\Http\Request $request
     * @param integer  $id row ID
     * @return CRUDController
     */
    public function fieldEditPost (Request $request, $id)
    {
        return parent::itemEditPost ($request, 'fields', $id);
    }

    /**
     * Action after update row data
     *
     * @param array  $updateData post data  for updating
     * @return void
     */
    protected function itemEditPostMutate ($updateData)
    {
        // Checking
        if ($updateData ['code'] != $this->Data['item']->code) {
            // Get field  type
            $fieldType = FieldType::where('id', $this->Data['item']->field_type_id)->first();

            // Get table data
            $tableModel = Table::where('id', $this->Data['item']->table_id)->first();

            $this->{$this->fieldClassByType($fieldType)}->updateFields($this->Data['item'], $updateData, $tableModel);
        }
    }

    /**
     * Call itemDelete with code 'fields'
     *
     * @param integer  $id row ID
     * @return CRUDController
     */
    public function fieldDelete ($id)
    {
        return parent::itemDelete ('fields',  $id);
    }

    /**
     * Action after delete row data
     * Deleting table column
     *
     * @param array  $rowData deleting row data
     * @return void
     */
    protected function itemDeleteMutate ()
    {
        // Get field  type
        $fieldType = FieldType::where('id', $this->Data['item']->field_type_id)->first();

        // Get table data
        $tableModel = Table::where('id', $this->Data['item']->table_id)->first();

        $this->{$this->fieldClassByType($fieldType)}->deleteFields($this->Data['item'], $tableModel);
    }

    /**
     * Create array with validate rules
     *
     * @param array  $fields table  fields  array
     * @return array
     */
    protected function createValidateArray ($fields, $mode)
    {
        // Add custom rules for field code
        $this->validateArray ['code'][] = new ColumnExists($this);
        $this->validateArray ['code'][] = new ColumnName();

        // Call main func
        parent::createValidateArray($fields, $mode);
    }
}
