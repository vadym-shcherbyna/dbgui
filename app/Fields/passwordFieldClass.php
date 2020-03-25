<?php

namespace App\Fields;

use Illuminate\Http\Request;
use App\Fields\fieldClass;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class passwordFieldClass  extends fieldClass
{
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
        $insertArray [$field->code] = bcrypt($request->input($field->code));
        return $insertArray;
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
                $table->string($code)->default('');
            });
        }
    }
}
