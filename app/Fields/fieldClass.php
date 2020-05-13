<?php

namespace App\Fields;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class fieldClass
{
    /**
     * Mutate field for adding  form
     *
     * @param  array $field
     * @return array
     */
    public function mutateAddGet ($field)
    {
        return $field;
    }

    /**
     * Mutate field for list of items
     *
     * @param  string $value
     * @param  array $field
     * @return array
     */
    public function mutateList ($value, $field = null)
    {
        return $value;
    }

    /**
     * Mutate field before  adding in database
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $field
     * @param  array $insertArray
     * @return string
     */
    public function mutateAddPost (Request $request, $field, $insertArray)
    {
        $insertArray [$field->code] = $request->input($field->code);
        return $insertArray;
    }

    /**
     * Mutate field for editing  form
     *
     * @param  array $field
     * @param  object $itemModel
     * @return array
     */
    public function mutateEditGet ($field, $itemModel)
    {
        return $field;
    }

    /**
     * Mutate field before adding in database after  editing
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $field
     * @param  array $updateArray
     * @return string
     */
    public function mutateEditPost (Request $request, $field, $updateArray)
    {
        $updateArray [$field->code] = $request->input($field->code);
        return $updateArray;
    }

    /**
     * Mutate field before delete item
     *
     * @param  object $row item model
     * @param  object $field field model
     * @return string
     */
    public function mutateDelete ($item, $field)
    {
        return $item->{$field->code};
    }

    /**
     * Update DB object, add  where clause
     *
     * @param  DB $model query builder
     * @param  array $field field data
     * @param  string $value value
     * @return DB
     */
    public function setFilterWhere ($model, $field,  $value)
    {
        $model  = $model->where($field->code, $value);

        return $model;
    }

    /**
     * Update  field data: set value
     *
     * @param  array $field field data
     * @param  array $table table data
     * @return DB
     */
    public function setFilterOptions ($field, $table)
    {
        // oprions array for select
        $field->options  = [];

        // set filter value in session
        if (request()->session()->has('filters.'.$table->code)) {
            $filters = request()->session()->get('filters.'.$table->code);

            if  (isset($filters[$field->id])) {
                $field->value = $filters [$field->id] ['value'];
            }
        }

        return $field;
    }

    /**
     * Create field/fields in  table
     *
     * @param  array $insertData array  for inserting
     * @param  object $tableModel current table model
     * @return void
     */
    public function createFields ($insertData, $tableModel)
    {
        $code = $insertData ['code'];

        if(Schema::hasColumn($tableModel->code, $code)) {
        }
        else {
            Schema::table($tableModel->code, function (Blueprint $table) use ($code) {
                $table->string($code, 191)->default('');
            });
        }
    }

    /**
     * Rename  field
     *
     * @param  array $updateData inserted array
     * @param  object $dbData row model from database
     * @param object $tableModel table model
     * @return void
     */
    public function updateFields($updateData, $tableModel)  {
        //
        $itemModel = $this->Data['item'];

        // Check field exists
        if(Schema::hasColumn($tableModel->code, $itemModel->code)) {
            // Rename field
            Schema::table($tableModel->code, function (Blueprint $table) use ($itemModel, $updateData) {
                $table->renameColumn($itemModel->code, $updateData ['code']);
            });
        };
    }

    /**
     * Delete field
     *
     * @param  array $itemModel item data from database
     * @param object $tableModel table model
     * @return void
     */
    public function deleteFields($tableModel)  {
        //
        $itemModel = $this->Data['item'];

        if(Schema::hasColumn($tableModel->code, $itemModel->code)) {
            Schema::table($tableModel->code, function (Blueprint $table) use ($itemModel) {
                $table->dropColumn($itemModel->code);
            });
        };
    }
}
