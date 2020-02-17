<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    /**
     * Set  name  of  fields  table.
     *
     * @var string
     */
    protected $table = 'fields';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationship: get the fields' group that owns the field.
     *
     * @return  object
     */
    public function type () {
        return $this->belongsTo('App\FieldType', 'field_type_id');
    }
}
