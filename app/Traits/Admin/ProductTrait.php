<?php

namespace App\Traits\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;

trait ProductTrait
{

    public function saveOrUpdateProduct($request)
    {
        try {
            DB::transaction(function () use($request) {
                $product = $this->saveOrupdateProductData($request);
            });
            return $this->successResponse();

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    protected function saveOrupdateProductData($request)
    {
        $imageName = "";
        if(!empty($request->file('product_image'))){
            try {
                $uploadImage = $request->file('product_image');
                $imagePath = "admin/assets/images/product_images/";
                $imageName = $this->saveProductImage($uploadImage, $imagePath);
                if ($request['image_old_value'] !== null && $request['image_old_value'] !== ""){
                    $this->removeOldImage($request['image_old_value'],$imagePath);
                }
            }
            catch (\Exception $e) {
                return $this->errorResponse($e->getMessage());
            }

        }else{
            if(isset($request['id'])){
                $imageName = $request['image_old_value'];
            }
        }

        $productData = [
            'name' => $request['product_name'],
            'public_id' => $request['product_short_description'],
            'description' => $request['product_description'],
            'additional_information' => $request['product_additional_information'],
            'price' => $request['product_price'],
            'product_type' => $request['product_type'],
            'product_index' => $request['product_index'],
            'image' => $imageName
        ];

        $productId = null;

        if ($request['id'] !== null){
            $productId = Crypt::decrypt($request['id']);
        }

        $product = Product::updateOrCreate(['id'=> $productId],$productData);
        return $product;
    }
    protected function saveProductImage($uploadImage, $imagePath)
    {

        $imageName = time() . '.' . $uploadImage->getClientOriginalExtension();
        $imagePath = public_path($imagePath . $imageName);
        Image::make($uploadImage->getRealPath())->save($imagePath);

        return $imageName;
    }

    public function removeOldImage($imageName,$imagePath)
    {
        // Check if the image exists
        $imageFullPath = public_path($imagePath . $imageName);
        if (file_exists($imageFullPath)) {
            // Delete the image file
            unlink($imageFullPath);
        }
    }

    protected function productNotFoundResponse()
    {
        return response()->json(['error' => 'Product not found'], 404);
    }

    protected function successResponse()
    {
        return response()->json(['success' => 'Product saved successfully']);
    }

    protected function errorResponse($message)
    {
        return response()->json(['error' => $message], 500);
    }

    public function deleteEntity($encryptedId, $modelClass, $imagePath = '', $imageNameField = null)
    {
        try {
            $id = Crypt::decrypt($encryptedId);

            $modelInstance = $modelClass::find($id);
            if ($modelInstance === null) {
                return response()->json(['error' => 'This entity does not exist.'], Response::HTTP_NOT_FOUND);
            }

            if ($imageNameField && !empty($modelInstance->$imageNameField)) {
                $imageFullPath = public_path($imagePath . $modelInstance->$imageNameField);
                if (file_exists($imageFullPath)) {
                    unlink($imageFullPath);
                }
            }

            $modelInstance->delete();

            return response()->json(['success' => 'Entity deleted successfully.'], Response::HTTP_OK);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid identifier.'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            \Log::error('Error deleting entity: '.$e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the entity.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
