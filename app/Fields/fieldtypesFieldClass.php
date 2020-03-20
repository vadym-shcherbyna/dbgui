<?php

namespace App\Fields;

use App\Fields\fieldClass;
use App\Table;
use App\FieldType;
use DB;
use Validator;
use Illuminate\Http\Request;

class fieldtypesFieldClass  extends fieldClass
{
    /**
     * Values  for select
     *
     * @var array
     */
    private $options = [];

    /**
     * Mutate field for adding  form
     *
     * @param  array $field
     * @return array
     */
    public function mutateAddGet ($field)
    {
        return $this->mutateEditGet ($field);
    }

    /**
     * Get  linked table and options for  select
     *
     * @param  array $field
     * @return array
     */
    public function mutateEditGet ($field)
    {
        // Mutate field: get field types exept syste, fields
        $field->options = FieldType::select('id', 'name', 'code')->where('flag_system', 0)->orderBy('id', 'ASC')->get();

        return $field;
    }

    /**
     * Create field/fields in  table
     *
     * @param  array $insertData inserting data
     * @param  object $table current table model
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
                $table->unsignedBigInteger('linked_data_id')->default(0);
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
        if(Schema::hasColumn($tableModel->code, 'linked_data_id')) {
            Schema::table($tableModel->code, function (Blueprint $table) use ($itemModel) {
                $table->dropColumn($itemModel->code);

                // Delete hidden  column
                $table->dropColumn('linked_data_id');
            });
        }
    }
}
