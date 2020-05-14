<?php

namespace App\Fields;

use App\Fields\fieldClass;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class varcharFieldClass  extends fieldClass
{
    /**
     * Update  query builder
     *
     * @param  DB $model query builder
     * @param  array $field field data
     * @param  string $value value
     * @return DB
     */
    public function setFilterWhere ($model, $field,  $value)
    {
        $model  = $model->where($field->code, 'LIKE', '%'.$value.'%');

        return $model;
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
                $table->string($code, 191)->nullable();
            });
        }
    }

    /**
     * Return validate rule
     *
     * @return string
     */
    public function getValidate($rules, $field, $mode)  {
        $rules [] = 'string';
        return $rules;
    }
}
