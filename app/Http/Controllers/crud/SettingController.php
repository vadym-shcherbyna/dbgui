<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\CRUDController;
use Illuminate\Http\Request;
use App\Setting;
use App\Table;

class SettingController extends CRUDController
{
    /**
     * Init
     *
     * @return void
     */
    protected function init ()
    {
        //  Get  table  model
        $this->Data ['table'] =  Table::where('code', 'settings')->first();

        // Get setting
        $settings =  Setting::all();
        foreach ($settings  as $setting) {
            $this->Data ['settings'] [$setting->code] = $setting;
        }
    }

    /**
     * Form View
     *
     * @return Response
     */
    public function form ()
    {
        //
        $this->init();

        return view('crud.pages.custom.setting', $this->Data);
    }

    /**
     * Save form data
     *
     * @param  \Illuminate\Http\Request $request
     * @return Responce
     */
    public function save (Request $request)
    {
        //
        $this->init();

        //
        foreach ($request->all() as $key => $field) {
            if (isset($this->Data ['settings'] [$key])) {
                $setting = Setting::where('code',  $key)->first();

                switch ($this->Data ['settings'] [$key]->type) {
                    case 'flag':
                        $value =  ($field) ? 1 : 0;
                        break;
                    case 'integer':
                        $value =  (int) $field;
                        break;
                    case 'string':
                        $value =  $field;
                        break;
                    default:
                        $value  =  $field;
                        break;
                }

                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect('/crud/settings/list');
    }
}
