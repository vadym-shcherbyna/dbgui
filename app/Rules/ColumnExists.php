<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Field;
use App\Table;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ColumnExists implements Rule
{
    /**
     * item Id
     *
     * @var object
     */
    private $fieldClass;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fieldClass)
    {
        $this->fieldClass = $fieldClass;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return boolean
     */
    public function passes($attribute, $value)
    {
        // Check registered fields
        // Need to checking row for unique in table: table ID, item ID, item code
        if (request()->has('table_id')) {
            $tableId = request()->input('table_id');
            $field = Field::where('table_id', $tableId)->where('code', $value)->first();
        } else {
            $tableId = $this->fieldClass->Data['item']->table_id;
            $itemId = $this->fieldClass->Data['item']->id;
            $field = Field::where('id', '<>', $itemId)->where('table_id', $tableId)->where('code', $value)->first();
        }

        if ($field)  return false;

        // Check unregistered fields
        $tableModel = Table::find($tableId);

        if(Schema::hasColumn($tableModel->code, $value)) {
            return false;
        }

		return  true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.column_exists');
    }
}