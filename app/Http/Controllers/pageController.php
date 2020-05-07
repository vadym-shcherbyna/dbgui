<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TableGroup;
use App\FieldType;
use App\Helpers\Settings;

class pageController extends Controller
{
    /**
     * Main array which pass  to  template (Illuminate\View\View object)
     *
     * @var array
     */
    public $Data = [];

    /**
     * Call itemAddPost with code 'tables'
     *
     * @return void
     */
    public function __construct()
    {
        // Select table groups
        $this->Data ['table_groups'] = TableGroup::with('tables')->orderBy('weight', 'DESC')->get();

        // Select  field types
        $fieldGroups = FieldType::orderBy('name', 'ASC')->get();

        // Init all field classes (types)
        foreach ($fieldGroups as $field) {
            $fieldName = $field->code.'FieldClass';
            $fieldClass = 'App\Fields\\'.$field->code.'FieldClass';
            $this->$fieldName = new $fieldClass;
        }

        // Creating clear predefined class
        $this->Data['table'] = new \stdClass;
        $this->Data['table']->table_group_id = 0;
        $this->Data['table']->code = '';
    }

    /**
     * Return field class name
     *
     * @return string
     */
    public function fieldClass ($field)
    {
        return $field->type->code.'FieldClass';
    }

    /**
     * Return field class name  by type
     *
     * @return string
     */
    public function fieldClassByType ($type)
    {
        return $type->code.'FieldClass';
    }
}
