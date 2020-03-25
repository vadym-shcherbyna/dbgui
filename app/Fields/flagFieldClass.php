<?php

namespace App\Fields;

use App\Fields\fieldClass;

class flagFieldClass  extends fieldClass
{
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
        $value = (int) $value;

        if ($value === 1) {
            $model  = $model->where($field->code, 1);
        } else {
            $model  = $model->where($field->code, 0);
        }

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
                $table->boolean($code)->default(0);
            });
        }
    }
}
