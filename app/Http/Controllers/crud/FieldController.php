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
     * @param array  $insertData row data after insert
     * @return void
     */
    protected function itemAddPostMutate ($insertData)
    {
        // Get field  type
        $fieldTypeModel = FieldType::where('id', $insertData ['field_type_id'])->first();

        // Get table data
        $tableModel = Table::where('id', $insertData ['table_id'])->first();

        //  Call Field class method  fir creating field
        $this->{$this->fieldClassByType($fieldTypeModel)}->createFields($insertData, $tableModel);
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
     * @param object  $dbData row model from database
     * @return void
     */
    protected function itemEditPostMutate ($updateData, $dbData)
    {
        // Checking
        if ($updateData ['code'] != $dbData->code) {
            // Get field  type
            $fieldType = FieldType::where('id', $dbData->field_type_id)->first();

            // Get table data
            $tableModel = Table::where('id', $dbData->table_id)->first();

            $this->{$this->fieldClassByType($fieldType)}->updateFields($updateData, $dbData,  $tableModel);
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
    protected function itemDeleteMutate ($itemModel)
    {
        // Get field  type
        $fieldType = FieldType::where('id', $itemModel->field_type_id)->first();

        // Get table data
        $tableModel = Table::where('id', $itemModel->table_id)->first();

        $this->{$this->fieldClassByType($fieldType)}->deleteFields($itemModel,  $tableModel);
    }

    /**
     * Create array with validate rules
     *
     * @param array  $fields table  fields  array
     * @return array
     */
    protected function createValidateArray ($fields)
    {
        // Add custom rules for field code
        $this->validateArray ['code'][] = new ColumnExists($this);
        $this->validateArray ['code'][] = new ColumnName();

        // Call main func
        parent::createValidateArray($fields);
    }
}
