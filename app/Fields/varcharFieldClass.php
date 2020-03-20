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
}
