<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Field;

class ColumnExists implements Rule
{
    /**
     * Row data
     *
     * @var object
     */
    private $rowModel;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($rowModel)
    {
        $this->rowModel = $rowModel;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rowModel
        // Set table ID  (table linked to row)
        $fieldModel = Field::find($id);
        $this->tableId  = $fieldModel->table_id;

        // Set row ID
        $this->rowId  = $id;

        if ($this->rowId  > 0) {
            $field = Field::where('id', '<>', $this->rowId)->where('table_id', $this->tableId)->where('code', $value)->first();
        } else {
            $field = Field::where('table_id', $this->tableId)->where('code', $value)->first();
        }

		return ($field) ? false : true;
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