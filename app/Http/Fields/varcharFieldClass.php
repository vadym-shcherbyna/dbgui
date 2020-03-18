<?php

namespace App\Http\Fields;

use App\Http\Fields\fieldClass;
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
     * @param  array $insertData inserting data
     * @param  object $table current table model
     * @return void
     */
    public function createFields ($insertData, $tableData)
    {
        $code = $insertData ['code'];

        if(Schema::hasColumn($tableData->code, $code)) {
        }
        else {
            Schema::table($tableData->code, function (Blueprint $table) use ($code) {
                $table->string($code, 191)->default('');
            });
        }
    }	
}
