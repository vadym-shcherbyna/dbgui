<?php

namespace App\Fields;

use App\Fields\fieldClass;
use App\Table;
use App\FieldType;
use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class fieldtypesFieldClass  extends fieldClass
{
    /**
     * Values  for select
     *
     * @var array
     */
    private $options = [];

    /**
     * Name for linked data  id column
     *
     * @var string
     */
    const LINKED_DATA_FIELD_NAME = 'linked_data_id';

    /**
     * Mutate field for adding  form
     *
     * @param  array $field
     * @return array
     */
    public function mutateAddGet ($field)
    {
        return $this->mutateEditGet ($field, null);
    }

    /**
     * Get  linked table and options for  select
     *
     * @param  array $field
     * @param  object $itemModel
     * @return array
     */
    public function mutateEditGet ($field, $itemModel)
    {
        // Field types
        $field->options = FieldType::select('id', 'name',  'code', 'description')->orderBy('weight', 'DESC')->get();

        // Linked  tables
        $field->linked_tables = Table::query()
            ->select('tables.id', 'tables.name')
            ->join('fields', function ($join) {
                $join->on('tables.id', '=', 'fields.table_id')->where('fields.code', 'name');
            })
            ->where('flag_system', '<>', 1)
            ->orderBy('name', 'ASC')
            ->get();

        return $field;
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
        $insertArray [self::LINKED_DATA_FIELD_NAME] = $request->input(self::LINKED_DATA_FIELD_NAME);
        $insertArray [$field->code] = $request->input($field->code);
        return $insertArray;
    }

    /**
     * Create field/fields in  table
     *
     * @param  array $insertData inserting data
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
                $table->unsignedBigInteger(self::LINKED_DATA_FIELD_NAME)->default(0);
            });
        }
    }

    /**
     * Delete  field
     *
     * @param  array $itemModel item data from database
     * @param object $tableModel table model
     * @return void
     */
    public function deleteFields($itemModel, $tableModel)
    {
        if(Schema::hasColumn($tableModel->code, self::LINKED_DATA_FIELD_NAME)) {
            Schema::table($tableModel->code, function (Blueprint $table) use ($itemModel) {
                $table->dropColumn($itemModel->code);

                // Delete hidden  column
                $table->dropColumn(self::LINKED_DATA_FIELD_NAME);
            });
        }
    }
}
