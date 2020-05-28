<?php

namespace App\Helpers;

use App\Helpers\Settings;
use Intervention;
use Storage;

use App\Image;

class ImageHelper
{
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
    public static function createPath ($key, $nesting_level, $disk)
    {
        $path = '';
        for($i=0;$i<$nesting_level;$i++){
            $path = $path . $key [$i].'/';
            Storage::disk($disk)->makeDirectory($path);
        }
    }

    /**
     * Main function uploading file via _FILES
     *
     * @param object $file
     * @param string $disk
     * @return string
     */
    public static function uploadImage ($file, $disk, $external = false)
    {
        // create path
        $key = ImageHelper::createName();
        $keyFolders = ImageHelper::getFoldersByKey($key, Settings::get('local_images_nesting_level'));

        // Local Spike for public disk (!)
        if ($disk != 's3') {
            ImageHelper::createPath ($key, Settings::get('local_images_nesting_level'), $disk);
        }

        $imagePath = $keyFolders.$key.'.jpg';

        // Create image
        if ($external) {
            $image = Intervention::make($file);
        } else {
            $image = Intervention::make($file->path());
        }

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

        // Save image
        Storage::disk($disk)->put($imagePath, $image->stream());

        // Add image
        $imageModel = Image::add($key, $image, 0, $disk);
        return $imageModel->id;
    }

    /**
     * Get patch  for image by key which saveing in database (md5)
     *
     * @param integer $imageId Image ID
     * @param string $disk
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
                $keyFolders = ImageHelper::getFoldersByKey($imageModel->key, $imageModel->nesting_level);
                $imageOriginalPath = $keyFolders.$imageModel->key.'.jpg';

                // New image path
                $width  ? $widthName = '-'.$width : $widthName = '';
                $height ? $heightName = '-'.$height : $heightName = '';
                $imageResizedKey = $imageModel->key.$widthName.$heightName;
                $imageResizedPath = $keyFolders.$imageModel->key.$widthName.$heightName.'.jpg';

                // Create resized image from original image
                if (Storage::disk($imageModel->disk)->exists($imageOriginalPath))  {
                    $image = Intervention::make(Storage::disk($imageModel->disk)->get($imageOriginalPath));
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
                Storage::disk($imageModel->disk)->put($imageResizedPath, $image->stream());

                // Add image
                $imageModel = Image::add($imageResizedKey, $image, $imageModel->id, $imageModel->disk, $width, $height);
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
    public static function deleteImage ($imageId, $disk)
    {
        $imageOriginalModel = Image::find($imageId);

        if ($imageOriginalModel) {
            ImageHelper::delete($imageOriginalModel, $disk);

            $resizedImages = Image::where('parent_id', $imageOriginalModel->id)->get();
            if (count($resizedImages) > 0) {
                foreach ($resizedImages as $image) {
                    ImageHelper::delete($image, $disk);
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
    public static function delete (Image $imageModel, $disk)
    {
        // Delete image
        $path = ImageHelper::getFoldersByKey($imageModel->key, $imageModel->nesting_level).$imageModel->key.'.jpg';
        Storage::disk($disk)->delete($path);

        // Delete model
        $imageModel->delete();
    }
}
