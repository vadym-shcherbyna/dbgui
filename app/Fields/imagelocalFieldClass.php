<?php

namespace App\Fields;

use App\Fields\imageFieldClass;

class imagelocalFieldClass  extends imageFieldClass
{
    /**
     * Disc name - binded in config/filesystem.php
     *
     * @var string
     */
    public $disk = 'public';
}
