<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use App\Table;

class FieldController extends CRUDController
{
    /**
     * Action after insert row data
     *
     * @param array  $insertData row data after insert
     * @return boolean
     */
    protected function itemAddPostMutate ($insertData)
    {
        return true;
    }

    /**
     * Action after update row data
     *
     * @param array  $oldData row data before update
     * @param array  $updatedData row data after update
     * @return boolean
     */
    protected function itemEditPostMutate ($oldData, $updatedData)
    {
        return true;
    }

    /**
     * Action after delete row data
     *
     * @param array  $rowData deleting row data
     * @return boolean
     */
    protected function itemDeleteMutate ($rowData)
    {
        return true;
    }
}
