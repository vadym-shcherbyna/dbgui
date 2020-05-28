<?php

namespace App\Fields;

use App\Fields\fieldClass;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Validator;
use DB;

use App\Helpers\ImageHelper;

class imageFieldClass  extends fieldClass
{
    /**
     * Mutate field for list of items
     *
     * @param  string $value
     * @param  array $field
     * @return array
     */
    public function mutateList ($value, $field = null)
    {
        if (empty($value)) {
            return false;
        } else {
            return ImageHelper::getImage ($value, 32, 32);
        }
    }

    /**
     * Mutate field before  adding in database
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $field
     * @param  array $insertArray
     * @return string
     */
    public function mutateAddPost (Request $request, $field, $insertArray)
    {
        $imageId = null;

        // Check isset  file
        if ($request->hasFile($field->code)) {
            if ($request->file($field->code)->isValid()) {
                $imageId = ImageHelper::uploadImage($request->file($field->code), $this->disk);
            }
        }

        $insertArray [$field->code] = $imageId;
        return $insertArray;
    }

    /**
     * Get  linked table and options for  select
     *
     * @param  array $field
     * @param  object $itemModel
     * @return array
     */
    public function mutateEditGet ($field, $itemModel)
    {
        if (!empty($itemModel->{$field->code})) {
            $preview = ImageHelper::getImage ($itemModel->{$field->code}, 128);
            if ($preview) {
                $field->preview = $preview;
            }
        }
        return $field;
    }

    /**
     * Mutate field before adding in database after  editing
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $field
     * @param  array $updateArray
     * @return string
     */
    public function mutateEditPost (Request $request, $field, $updateArray)
    {

        $imageKey = null;
        // Keep old image
        if ($request->has($field->code.'_old')) {
            $imageKey = $request->input($field->code.'_old');
        }

        if ($request->hasFile($field->code)) {
            if ($request->file($field->code)->isValid()) {
                // Delete old image
                if ($request->has($field->code.'_old')) {
                    ImageHelper::DeleteImage($request->input($field->code.'_old'), $this->disk);
                }

                // Upload  new image
                $imageKey = ImageHelper::uploadImage($request->file($field->code), $this->disk);
            }
        }

        $updateArray [$field->code] = $imageKey;
        return $updateArray;
    }

    /**
     * Mutate field before delete item
     *
     * @param  object $row item model
     * @param  object $field field model
     * @return string
     */
    public function mutateDelete ($item, $field)
    {
        $value = $item->{$field->code};

        if($value) {
            ImageHelper::deleteImage($value, $this->disk);
        }
        return $value;
    }

    /**
     * Create field/fields in  table
     *
     * @param  array $insertData array  for inserting
     * @param  object $tableModel current table model
     * @return void
     */
    public function createFields ($insertData, $tableModel)
    {
        $code = $insertData ['code'];

        if(Schema::hasColumn($tableModel->code, $code)) {

        } else {
            Schema::table($tableModel->code, function (Blueprint $table) use ($code) {
                $table->unsignedBigInteger($code)->nullable();
            });
        }
    }

    /**
     * Return validate rule
     *
     * @return string
     */
    public function getValidate($rules, $field, $mode)  {
        //
        $rules = [];

        $rules [] = 'image';

        if ($mode == 'add') {
            if ($field->flag_required) {
                $rules [] = 'required';
            } else {
                $rules [] = 'nullable';
            }
        }

        if ($mode == 'edit') {
            $rules [] = 'nullable';
        }

        return $rules;
    }
}
