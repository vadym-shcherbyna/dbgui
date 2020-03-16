<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    /**
     * Set  name  of  fields  table.
     *
     * @var string
     */
    protected $table = 'field_types';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
