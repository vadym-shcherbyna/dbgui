<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /**
     * Set  name  of  fields  table.
     *
     * @var string
     */
    protected $table = 'tables';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Ralationships: "view" fields to  table
     *
     */
    public function fieldsView()
    {
        return $this->hasMany('App\Field', 'table_id')->where('flag_view', 1)->orderBy('weight', 'DESC');
    }

    /**
     * Ralationships: edit fields to  table
     *
     */
    public function fieldsEdit()
    {
        return $this->hasMany('App\Field', 'table_id')->where('flag_edit', 1)->orderBy('weight', 'DESC');
    }

    /**
     * Ralationships: all fields to  table
     *
     */
    public function fields()
    {
        return $this->hasMany('App\Field', 'table_id')->orderBy('weight', 'DESC');
    }

    /**
     * Ralationships: "filter" fields to  table
     *
     */
    public function filters()
    {
        return $this->hasMany('App\Field', 'table_id')->where('flag_filter', 1)->orderBy('weight', 'DESC');
    }
}
