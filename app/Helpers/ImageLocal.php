<?php

namespace App\Helpers;

use Storage;
use Intervention;

use App\Helpers\Settings;
use App\Image;

class ImageLocal
{
    /**
     * Disc name - binded in config/filesystem.php
     *
     * @var string
     */
    const DISC_NAME = 'public';

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
    public static function getFoldersByKey ($key, $nesting_level)
    {
        $path = '';
        for($i=0;$i<$nesting_level;$i++){
            $path = $path . $key [$i].'/';
        }
        return $path;
    }

    /**
     * Create  folders according  to filename (separate patches)
     *
     * @param string $objectName filename of image
     * @return void
     */
    public static function createPath ($key, $nesting_level)
    {
        $path = '';
        for($i=0;$i<$nesting_level;$i++){
            $path = $path . $key [$i].'/';
            Storage::disk(self::DISC_NAME)->makeDirectory($path);
        }
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
        ImageLocal::createPath ($key, Settings::get('local_images_nesting_level'));
        $keyFolders = ImageLocal::getFoldersByKey($key, Settings::get('local_images_nesting_level'));
        $imagePath = config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$keyFolders.$key.'.jpg';

        // upload image
        $image = Intervention::make($file->path());

        // Checking  width&height
        $imageWidth = $image->width();
        $imageHeight = $image->height();
        $maxWidth = Settings::get('local_image_width_max');
        $maxHeight = Settings::get('local_image_height_max');
        $encodeQuality = Settings::get('local_image_encode_quality');

        if ($imageWidth > $maxWidth) {
            $imageWidth = $maxWidth;
            $image->resize($imageWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($imageHeight > $maxHeight) {
            $imageHeight = $maxHeight;
            $image->resize(null, $imageHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // Convert  to JPEG
        $image->encode('jpg', $encodeQuality);

        //
        $image->save($imagePath);

        //
        $imageModel = new Image;
        $imageModel->key = $key;
        $imageModel->width = $imageWidth;
        $imageModel->height = $imageHeight;
        $imageModel->filesize = $image->filesize();
        $imageModel->nesting_level = Settings::get('local_images_nesting_level');
        $imageModel->save();

        return $imageModel->id;
    }

    /**
     * Get patch  for image by key which saveing in database (md5)
     *
     * @param integer $imageId Image ID
     * @param string $width
     * @param string $height
     * @return string
     */
    public static function getImage ($imageId, $width = null, $height = null)
    {
        // Get original image
        $imageModel = Image::find($imageId);

        if ($imageModel) {
            // Return original image
            if ($width == null && $height == null) {
                return $imageModel;
            }

            // Finding resized image
            $imageResizedModel = Image::query()->where('parent_id', $imageId);
            if ($width) {
                $imageResizedModel = $imageResizedModel->where('width', $width);
            }
            if ($height) {
                $imageResizedModel = $imageResizedModel->where('height', $height);
            }
            $imageResizedModel = $imageResizedModel->first();

            if ($imageResizedModel) {
                return $imageResizedModel;
            } else {
                // Create resized image

                // Get original image path
                $keyFolders = ImageLocal::getFoldersByKey($imageModel->key, $imageModel->nesting_level);
                $imageOriginalPath = $keyFolders.$imageModel->key.'.jpg';

                // New image path
                $width  ? $widthName = '-'.$width : $widthName = '';
                $height ? $heightName = '-'.$height : $heightName = '';
                $imageResizedKey = $imageModel->key.$widthName.$heightName;
                $imageResizedPath = $keyFolders.$imageModel->key.$widthName.$heightName.'.jpg';

                //
                if (Storage::disk(self::DISC_NAME)->exists($imageOriginalPath))  {
                    $image = Intervention::make(config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$imageOriginalPath);
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

                // Save image
                $image->save(config('filesystems.disks.'.self::DISC_NAME.'.root').'/'.$imageResizedPath);

                //
                $imageModel = new Image;
                $imageModel->parent_id = $imageId;
                $imageModel->key = $imageResizedKey;
                $imageModel->width = $width;
                $imageModel->height = $width;
                $imageModel->filesize = $image->filesize();
                $imageModel->nesting_level = Settings::get('local_images_nesting_level');

                $imageModel->save();

                return $imageModel;
            }
        }

        return false;
    }

    /**
     * Delete image by Id
     *
     * @param integer $imageId Image ID
     * @return void
     */
    public static function deleteImage ($imageId)
    {
        $imageOriginalModel = Image::find($imageId);

        if ($imageOriginalModel) {
            ImageLocal::delete($imageOriginalModel);

            $resizedImages = Image::where('parent_id', $imageOriginalModel->id)->get();
            if (count($resizedImages) > 0) {
                foreach ($resizedImages as $image) {
                    ImageLocal::delete($image);
                }
            }
        }
    }

    /**
     * Delete image by Id
     *
     * @param object $imageModel Image object
     * @return void
     */
    public static function delete (Image $imageModel)
    {
        // Delete image
        $path = ImageLocal::getFoldersByKey($imageModel->key, $imageModel->nesting_level).$imageModel->key.'.jpg';
        Storage::disk(self::DISC_NAME)->delete($path);

        // Delete model
        $imageModel->delete();
    }
}
