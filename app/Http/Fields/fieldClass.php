<?php

namespace App\Http\Fields;

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
     * @return string
     */
    public function mutateAddPost (Request $request, $field)
    {
        return $request->input($field->code);
    }

    /**
     * Mutate field for editing  form
     *
     * @param  array $field
     * @return array
     */
    public function mutateEditGet ($field)
    {
        return $field;
    }

    /**
     * Mutate field before adding in database after  editing
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $field
     * @return string
     */
    public function mutateEditPost (Request $request, $field)
    {
        return $request->input($field->code);
    }

    /**
     * Mutate field before delete item
     *
     * @param  array $row field settings
     * @param  array $field field data
     * @return string
     */
    public function mutateDelete ($row, $field)
    {
        return $row->{$field->code};
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
     * Rename  field
     *
     * @param  array $updateData inserted array
     * @param  object $dbData row model from database
     * @param object $tableModel table model
     * @return void
     */
    public function updateFields($updateData, $dbData,  $tableModel)  {
        Schema::table($tableModel->code, function (Blueprint $table) use ($dbData, $updateData) {
            $table->renameColumn($dbData->code, $updateData ['code']);
        });
    }
}
