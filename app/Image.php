<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\ImageHelper;
use App\Helpers\Settings;

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
        if ($this->disk == 'public') {
            $path = env('APP_URL').'/storage/'.ImageHelper::getFoldersByKey($this->key, $this->nesting_level).$this->key.'.jpg';
        }
        if ($this->disk == 's3') {
            $path = 'https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'
                .ImageHelper::getFoldersByKey($this->key, $this->nesting_level).$this->key.'.jpg';
        }
        return $path;
    }

    /**
     * Add image
     *
     * @return string
     */
    public static function add($key, $image, $parent_id, $disk, $width = null, $height = null)
    {
        $imageModel = new Image;
        $imageModel->key = $key;
        $imageModel->disk = $disk;
        $imageModel->parent_id = $parent_id;
        if ($width) {
            $imageModel->width = $width;
        } else {
            $imageModel->width = $image->width();
        }
        if ($height) {
            $imageModel->width = $height;
        } else {
            $imageModel->height = $image->height();
        }
        $imageModel->filesize = $image->filesize();
        $imageModel->nesting_level = Settings::get('local_images_nesting_level');
        $imageModel->save();
        return $imageModel;
    }
}
