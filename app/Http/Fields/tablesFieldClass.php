<?php

namespace App\Http\Fields;

use App\Http\Fields\fieldClass;
use App\Table;
use DB;
use Validator;
use Illuminate\Http\Request;

class tablesFieldClass  extends fieldClass
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
     * Mutate field for list of items
     *
     * @param  string $value
     * @param  array $field
     * @return array
     */
    public function mutateList ($value, $field =  null)
    {
        // Set select's options if they  don't  exist
        if (!isset($this->options[$field->code]))  {
            $linkedTable = Table::find($field->linked_table_id);

            if ($linkedTable) {
                $this->options[$field->code] = DB::table($linkedTable->code)->orderBy('id', 'ASC')->get();
            }
        }

        // Mutate value
        foreach ($this->options[$field->code] as $option) {
            if ($value == $option->id) {
                $value = $option->name;

                return $value;
            }
        }
    }

    /**
     * Get  linked table and options for  select
     *
     * @param  array $field
     * @return array
     */
    public function mutateEditGet ($field)
    {
        // Get  linked table
        $linkedTable = Table::find($field->linked_table_id);

        // get options for select
        if ($linkedTable) {
            $field->options = DB::table($linkedTable->code)->select('id', 'name')->orderBy('id', 'ASC')->get();
        }

        return $field;
    }

    /**
     * Get  options  for select
     *
     * @param  array $field
     * @param  array $table
     * @return array
     */
    public function setFilterOptions ($field, $table)
    {
        $field->options  =  [];

        if (isset($this->options[$field->code]))  {
            $field->options =  $this->options[$field->code];
        } else {
            $linkedTable = Table::find($field->linked_table_id);

            if ($linkedTable) {
                    $field->options = DB::table($linkedTable->code)->select('id', 'name')->orderBy('name', 'ASC')->get();
            }
        }

        if (request()->session()->has('filters.'.$table->code)) {
            $filters = request()->session()->get('filters.'.$table->code);

            if  (isset($filters[$field->id])) {
                $field->value = $filters [$field->id] ['value'];
            }
        }

        return $field;
    }
}