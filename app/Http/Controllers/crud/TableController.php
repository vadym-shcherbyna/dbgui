<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;

class TableController extends CRUDController
{
    /**
     * Call itemAddPost with code 'tables'
     *
     * @param  \Illuminate\Http\Request $request
     * @return CRUDController
     */
    public function tableAddPost (Request $request)
    {
        return parent::itemAddPost ($request, 'tables');
    }

    /**
     * Action after insert row data
     *
     * @param array  $insertData row data after insert
     * @return void
     */
    protected function itemAddPostMutate ($insertData)
    {
        //  Create table with one  row
        Schema::create($insertData ['code'], function (Blueprint $table) {
            $table->increments('id');
        });
    }

    /**
     * Call itemEditPost with code 'tables'
     *
     * @param  \Illuminate\Http\Request $request
     * @param integer  $id row ID
     * @return CRUDController
     */
    public function tableEditPost (Request $request, $id)
    {
        return parent::itemEditPost ($request, 'tables', $id);
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
        if ($updateData ['code'] != $dbData->code) {
            Schema::rename($dbData->code, $updateData ['code']);
        }
    }

    /**
     * Call itemDelete with code 'tables'
     *
     * @param integer  $id row ID
     * @return CRUDController
     */
    public function tableDelete ($id)
    {
        return parent::itemDelete ('tables',  $id);
    }

    /**
     * Action after delete row data
     *
     * @param array  $rowData deleting row data
     * @return void
     */
    protected function itemDeleteMutate ($itemModel)
    {
        Schema::dropIfExists($itemModel->code);
    }
}
