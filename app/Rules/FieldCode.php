<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Field;

class FieldCode implements Rule
{
    /**
     * Table ID
     *
     * @var integer
     */
    private $tableId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tableId)
    {
        $this->tableId = $tableId;
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
        $field = Field::where('table_id', $this->tableId)->where('code', $value)->first();

		return ($field) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique_by_table');
    }
}