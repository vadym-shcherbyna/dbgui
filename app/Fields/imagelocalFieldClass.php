<?php

namespace App\Fields;

use App\Fields\fieldClass;
use App\Table;
use DB;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\ImageLocal;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class imagelocalFieldClass  extends fieldClass
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
            return ImageLocal::getImage ($value, 32, 32);
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
                $imageId = ImageLocal::uploadImage($request->file($field->code));
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
            $field->preview = ImageLocal::getImage ($itemModel->{$field->code}, 128);
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
        if ($request->has($field->code)) {
            $imageKey = $request->input($field->code);
        }

        if ($request->hasFile($field->code)) {
            if ($request->file($field->code)->isValid()) {
                // Delete old image
                if ($request->has($field->code)) {
                    ImageLocal::DeleteImage($request->input($field->code));
                }

                // Upload  new image
                $imageKey = ImageLocal::uploadImage($request->file($field->code));
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
            ImageLocal::deleteImage($value);
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
                $table->unsignedBigInteger($code)->default(0);
            });
        }
    }
}
