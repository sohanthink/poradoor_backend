<?php

namespace App\Traits\CRUD; // ফোল্ডার নাম সাধারণত বহুবচন (Traits) হয়

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Http\JsonResponse;

trait CrudOperation
{
    /**
     * Common Success Response
     */
    private function apiSuccess($data, $message, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Common Error Response
     */
    private function apiError($message, $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    /**
     * Store a newly created resource.
     */
    public function storeModel(string $modelName, array $data, $afterCreate = null): JsonResponse
    {
        $request = request();
        $onlyModelName = class_basename($modelName);

        try {
            DB::beginTransaction();

            $model = $modelName::create($data);

            if ($request->hasFile('image')) {
                ImageHelper::uploadImage($model, $request, 'image');
            }

            if ($request->hasFile('multiple_image')) {
                ImageHelper::uploadMultipleImages($model, $request, 'multiple_image');
            }

            if ($afterCreate && is_callable($afterCreate)) {
                call_user_func($afterCreate, $model);
            }

            DB::commit();
            return $this->apiSuccess($model, ucfirst($onlyModelName) . ' created successfully!', 201);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->apiError('Failed to create ' . strtolower($onlyModelName) . ': ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource.
     */
    public function updateModel(string $modelName, $id, array $data, $afterUpdate = null): JsonResponse
    {
        $request = request();
        $onlyModelName = class_basename($modelName);
        $model = $modelName::find($id);

        if (!$model) {
            return $this->apiError(ucfirst($onlyModelName) . ' not found.', 404);
        }

        try {
            DB::beginTransaction();

            $model->update($data);

            if ($request->hasFile('image')) {
                if ($model->hasMedia('image')) {
                    $model->clearMediaCollection('image');
                }
                ImageHelper::uploadImage($model, $request, 'image');
            }

            if ($request->hasFile('multiple_image')) {
                if ($model->hasMedia('multiple_image')) {
                    $model->clearMediaCollection('multiple_image');
                }
                ImageHelper::uploadMultipleImages($model, $request, 'multiple_image');
            }

            if ($afterUpdate && is_callable($afterUpdate)) {
                call_user_func($afterUpdate, $model);
            }

            DB::commit();
            return $this->apiSuccess($model, ucfirst($onlyModelName) . ' updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->apiError('Failed to update ' . strtolower($onlyModelName) . ': ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroyModel(string $modelName, $id): JsonResponse
    {
        $onlyModelName = class_basename($modelName);
        $model = $modelName::find($id);

        if (!$model) {
            return $this->apiError(ucfirst($onlyModelName) . ' not found.', 404);
        }

        try {
            // Media checking
            if (in_array(InteractsWithMedia::class, class_uses($model)) && $model->hasMedia()) {
                $model->clearMediaCollection();
            }

            $model->delete();
            return $this->apiSuccess(null, ucfirst($onlyModelName) . ' deleted successfully!');
        } catch (\Exception $e) {
            // Integrity constraint check (ForeignKey Error)
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), '1451')) {
                return $this->apiError('This ' . strtolower($onlyModelName) . ' is associated with other records and cannot be deleted.', 409);
            }
            return $this->apiError('An error occurred while deleting.');
        }
    }
}
