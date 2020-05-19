<?php

namespace App\Fields;

use App\Fields\imageFieldClass;

class images3FieldClass  extends imageFieldClass
{
    /**
     * Disc name - binded in config/filesystem.php
     *
     * @var string
     */
    public $disk = 's3';
}
