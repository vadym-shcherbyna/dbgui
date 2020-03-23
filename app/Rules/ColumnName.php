<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ColumnName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $value, $matches)) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.column_name');
    }
}