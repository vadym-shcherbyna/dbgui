<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use App;
use Lang;

use App\TableGroup;
use App\FieldType;

use App\Helpers\LangHelper;

class PageController extends Controller
{
    /**
     * Main array which pass  to  template (Illuminate\View\View object)
     *
     * @var array
     */
    public $Data = [];

    /**
     * List of meta tags
     *
     * @var array
     */
    public $metaCodes = [
        'title',
        'keywords',
        'description',
    ];

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

        //
        $this->Data ['breadcrumbs'] = [];
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

    /**
     * Return view
     *
     * @param string route name
     * @return void
     */
    public function view($view)
    {
        // Languages
        $this->Data ['languages'] = LangHelper::$languageList;

        // Set lang
        $this->Data ['lang'] = App::getLocale();

        // Set current route name
        $this->Data ['routeName'] = Route::currentRouteName();

        // Set meta
        $this->setMetaFromLocale();

        return view($view, $this->Data);
    }

    /**
     * Return view
     *
     * @param string route name
     * @return void
     */
    public function setMetaFromLocale()
    {
        foreach ($this->metaCodes as $code) {
            if (Lang::has('crud.'.$this->Data ['routeName'].'.meta.'.$code,  App::getLocale())) {
                if (!isset($this->Data [$code])) {
                    $this->Data [$code] = Lang::get('crud.'.$this->Data ['routeName'].'.meta.'.$code);
                }
            }
        }
    }

    /**
     * Unauthorized action page
     *
     * @return Responce
     */
    public function unauthorizedPage()
    {
        abort(403);
    }

    /**
     * Not found  page
     *
     * @return Responce
     */
    public function notFoundPage()
    {
        abort(404);
    }
}
