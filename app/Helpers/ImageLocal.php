<?php

namespace App\Helpers;

use Storage;
use Image;
use App\Helpers\Settings;

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
     * Get patch to image by key
     *
     * @param string $key
     * @return string
     */
    public static function getFoldersByKey ($key)
    {
        return $key [0].'/'.$key [1].'/'.$key [2].'/';
    }

    /**
     * Create  folders according  to filename (separate patches)
     *
     * @param string $objectName filename of image
     * @return void
     */
    public static function createPath ($objectName)
    {
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0]);
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0].'/'.$objectName[1]);
        Storage::disk(self::DISC_NAME)->makeDirectory($objectName[0].'/'.$objectName[1].'/'.$objectName[2]);
    }

    /**
     * Main function uploading file via _FILES
     *
     * @param object $file
     * @return string
     */
    public static function uploadImage ($file)
    {
        // create path
        $key = ImageLocal::createName();
        ImageLocal::createPath ($key);
        $keyFolders = ImageLocal::getFoldersByKey($key);
        $imagePath = config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$keyFolders.$key.'.jpg';

        // upload image
        $image = Image::make($file->path());

        // Checking  width&height
        $width = $image->width();
        $height = $image->height();
        $maxWidth = Settings::get('local_image_width_max');
        $maxHeight = Settings::get('local_image_height_max');
        $encodeQuality = Settings::get('local_image_encode_quality');

        if ($width > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($height > $maxHeight) {
            $image->resize(null, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // Convert  to JPEG
        $image->encode('jpg', $encodeQuality);

        $image->save($imagePath);

        return $key;
    }

    /**
     * Get patch  for image by key which saveing in database (md5)
     *
     * @param string $key 32 long hash string
     * @param string $width
     * @param string $height
     * @return string
     */
    public static function getImage ($key, $width = null, $height = null)
    {
        // Prepare key
        $key = trim ($key);
        if (empty($key)) return false;

        // Setting
        $width  ? $widthName = '.'.$width : $widthName = '';
        $height ? $heightName = '.'.$height : $heightName = '';

        // Patches
        $keyFolders = ImageLocal::getFoldersByKey($key);
        $imagePath = $keyFolders.$key.$widthName.$heightName.'.jpg';
        $imageSourcePath = $keyFolders.$key.'.jpg';

        // Check exists
        if (Storage::disk(self::DISC_NAME)->exists($imagePath))  {
            return env('APP_URL').'/storage/'.self::DISC_NAME.'/'.$imagePath;
        }

        // Create image
        if (Storage::disk(self::DISC_NAME)->exists($imageSourcePath))  {
            $image = Image::make(config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$imageSourcePath);
        } else {
            return false;
        }

        // Resize image
        if ($width || $height) {
            if ($width && $height) {
                // Crop image
                $image->fit($width, $height, function ($img) {
                    $img->upsize();
                });
            } else {
                //  Resize image with ratio
                $image->resize($width, $height, function ($img) {
                    $img->aspectRatio();
                    $img->upsize();
                });
            }
        }

        $image->save(config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$imagePath);

        return env('APP_URL').'/storage/'.self::DISC_NAME.'/'.$imagePath;
    }

    /**
     * Delete image by key
     *
     * @param string $key 32 long hash string
     * @return void
     */
    public static function DeleteImage ($key)
    {
        if (!empty($key)) {
            $keyFolders = ImageLocal::getFoldersByKey($key);
            $imagePath =  $keyFolders.$key;

            $images = Storage::disk(self::DISC_NAME)->allFiles($keyFolders);

            foreach ($images as $key => $value) {
                $pos = strpos($value, $imagePath);
                if ($pos === false) {
                }
                else {
                    Storage::disk(self::DISC_NAME)->delete($value);
                }
            }
        }
    }
}
