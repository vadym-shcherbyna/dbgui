<?php

namespace App\Helpers;

use Storage;
use Image;

class ImageLocal
{
    /**
     * Disc name - binded in config/filesystem.php
     *
     * @var string
     */
    const DISC_NAME = 'imagelocal';

    /**
     * Create  random file name fir image
     *
     * @return string
     */
    public static function createName ()
    {
        return md5 (time().mt_rand());
    }

    /**
     * Create  random file name fir image
     *
     * @param string $objectName filename of image
     * @return void
     */
    public static function createPath ($objectName)
    {
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0]);
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0].'/'.$objectName[1]);
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0].'/'.$name[1].'/'.$objectName[2]);
    }

    /**
     * Create  random file name fir image
     *
     * @param object $file
     * @return void
     */
    public static function uploadImage ($file)
    {
        // create path
        $imageName = ImageLocal::createName();

        ImageLocal::createPath ($imageName);

        $imagePath = config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$imageName [0].'/'.$imageName [1].'/'.$imageName [2].'/'.$imageName.'.jpg';

        // upload image

        $image = Image::make($file->path());

        $width = $image->width();

        if ($width > 1024) {

            $image->resize(1024, null, function ($constraint) {

                $constraint->aspectRatio();

            });

        }

        $image->encode('jpg', 90);

        $image->save($imagePath);

        return $name;

    }

    // Upload global image

    public static function UploadExternalImage ($path, $disk) {

        $path = trim ($path);

        if (!empty($path)) {

            // Download file

            if ($image = Image::make($path)) {

                $name = imagesLocal::CreateName();

                imagesLocal::CreatePath ($name, $disk);

                $imagePath = config('filesystems.disks.'.$disk.'.root').'/'.$name [0].'/'.$name [1].'/'.$name [2].'/'.$name.'.jpg';

                //

                $width = $image->width();

                if ($width > 1024) {

                    $image->resize(1024, null, function ($constraint) {

                        $constraint->aspectRatio();

                    });

                }

                $image->encode('jpg', 90);

                $image->save($imagePath);

                return $name;

            }

        }

        return false;

    }

    //

    public static function GetImage ($key, $disk, $width = FALSE, $height = FALSE) {

        // Prepare key

        $key = trim ($key);

        if (empty($key)) return false;

        // Setting

        $width  ? $widthname = '.'.$width : $widthname = '';
        $height ? $heightname = '.'.$height : $heightname = '';

        // Patches

        $ImagePath = $key [0].'/'.$key [1].'/'.$key [2].'/'.$key.$widthname.$heightname.'.jpg';

        $ImageSourcePath = $key [0].'/'.$key [1].'/'.$key [2].'/'.$key.'.jpg';

        // Check exists

        if (Storage::disk($disk)->exists($ImagePath))  {

            return env('APP_URL').'/storage/'.$disk.'/'.$ImagePath;

        }

        // Create image

        if (Storage::disk($disk)->exists($ImageSourcePath))  {

            $image = Image::make(config('filesystems.disks.'.$disk.'.root').'/'.$ImageSourcePath);

        }
        else {

            return false;

        }

        // Resize

        if (!$width) {

            $image->resize(null, $height, function ($constraint) {

                $constraint->aspectRatio();

            });

        }

        if (!$height) {

            $image->resize($width, null, function ($constraint) {

                $constraint->aspectRatio();

            });

        }

        $image->save(config('filesystems.disks.'.$disk.'.root').'/'.$ImagePath);

        return env('APP_URL').'/storage/'.$disk.'/'.$ImagePath;

    }


    // DeleteImage

    public static function DeleteImage ($key, $disk) {

        if (!empty($key)) {

            $imagePath = $key [0].'/'.$key [1].'/'.$key [2].'/'.$key;

            $images = Storage::disk($disk)->allFiles($key [0].'/'.$key [1].'/'.$key [2]);

            foreach ($images as $key => $value) {

                $pos = strpos($value, $imagePath);

                if ($pos === false) {

                }
                else {

                    Storage::disk($disk)->delete($value);

                }

            }

        }

    }

}
