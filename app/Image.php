<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\ImageLocal;

class Image extends Model
{
    /**
     * Set  name  of  fields  table.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * Get image path according to key.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        $path = env('APP_URL').'/storage/'.ImageLocal::getFoldersByKey($this->key, $this->nesting_level).$this->key.'.jpg';
        return $path;
    }
}
