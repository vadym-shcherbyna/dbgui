<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Settings;

class TableGroup extends Model
{
    /**
     * Set  name  of  table groups  table.
     *
     * @var string
     */
    protected $table = 'table_groups';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Ralationships: tables to  table groups
     *
     */
    public function tables()
    {
        if (Settings::get('dev_mode_tables')) {
            return $this->hasMany('App\Table', 'table_group_id')->orderBy('weight', 'DESC');
        } else {
            return $this->hasMany('App\Table', 'table_group_id')->where('flag_view', 1)->orderBy('weight', 'DESC');
        }
    }
}
