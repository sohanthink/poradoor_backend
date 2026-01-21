<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;

class ImageHelper
{
    /**
     * Handle image upload for a given model.
     *
     * @param object $model The model instance
     * @param Request $request The request object
     * @param string $fieldName The name of the input field in the request
     * @param string $collectionName The name of the media collection
     * @return Media|null
     */
    public static function uploadImage($model, Request $request, string $fieldName)
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        try {
            $old_image = $model->getFirstMedia($fieldName);
            $result = $model->addMedia($request->file($fieldName))
                ->usingName(Str::slug($model->name) . '-' . uniqid())
                ->toMediaCollection($fieldName);
            if($result && $old_image){
                try {
                    $old_image->delete();
                } catch (\Throwable $th){}
            }
            return $result;
        } catch (\Exception $e) {
            // Log the error (optional)
            \Log::error('Image upload failed for ' . get_class($model) . ': ' . $e->getMessage());
            return false; // Indicate upload failure
        }
    }
    public static function uploadMultipleImages($model, Request $request, string $fieldName)
    {
        if (!$request->hasFile($fieldName)) {
            return null; // No images uploaded
        }

        $images = [];
        foreach ($request->file($fieldName) as $image) {
            try {
                $images[] = $model->addMedia($image)
                    ->usingName(Str::slug($model->name) . '-' . uniqid())
                    ->toMediaCollection($fieldName);
            } catch (\Exception $e) {
                \Log::error('Image upload failed for ' . get_class($model) . ': ' . $e->getMessage());
            }
        }

        return $images;
    }

    public static function setting_img_update($name,$request){

        if ($request->hasFile($name)) {
            $setting = Setting::firstOrCreate(['name'=> $name],['value' => $name]);
            if ($setting->hasMedia($name)) {
                $setting->clearMediaCollection($name);
            }

            self::uploadImage($setting, $request,$name);
         }
    }

    public static function uploadColorSpecificImage(Model $model, $image, string $collectionName, string $color)
    {
        if ($image) {
            $model->addMedia($image)
                ->withCustomProperties(['color' => $color])
                ->toMediaCollection($collectionName);
        }
    }
}


