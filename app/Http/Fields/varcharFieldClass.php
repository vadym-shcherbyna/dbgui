<?php

namespace App\Http\Fields;

use App\Http\Fields\fieldClass;

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
}
