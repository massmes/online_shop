<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Wavey\Sweetalert\Sweetalert;
use Exception;


class ProductImageController extends Controller
{
    public function upload($primaryImage, $images)
    {
        $fileNamePrimaryImage = generateFileName($primaryImage->getClientOriginalName());

        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNamePrimaryImage);

        $fileNameImages = [];
        foreach ($images as $image) {
            $fileNameImage = generateFileName($image->getClientOriginalName());

            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);

            array_push($fileNameImages, $fileNameImage);
        }

        return ['fileNamePrimaryImage' => $fileNamePrimaryImage, 'fileNameImages' => $fileNameImages];
    }


    public function edit(Product $product, $title)
    {
        return view('admin.products.edit_images', compact('product', 'title'));
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'image_id' => 'required|exists:product_images,id',
        ]);

        ProductImage::destroy($request->image_id);

        toastr()->warning('عملیات حذف موفقیت آمیز بود', 'تصویر محصول حذف شد', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
        return redirect()->back();
    }


    public function setPrimary(Request $request, Product $product)
    {
        $validated = $request->validate([
            'image_id' => 'required|exists:product_images,id',
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);
        $product->update([
            'primary_image' => $productImage->image,
        ]);

        toastr()->warning('عملیات موفقیت آمیز بود', 'تصویر اصلی محصول ویرایش شد', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
        return redirect()->back();
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'primary_image' => 'nullable|mimes:jpg,jpeg,svg,png,gif,webp',
            'images.*' => 'nullable|mimes:jpg,jpeg,svg,png,gif,webp',
        ]);

        if ($request->primary_image == null && $request->images == null) {
            return redirect()->back()->withErrors(['msg' => 'انتخاب تصویر یا تصاویر محصول الزامی است']);
        }

        try {
            DB::beginTransaction();

            if ($request->has('primary_image')) {

                $fileNamePrimaryImage = generateFileName($request->primary_image->getClientOriginalName());
                $request->primary_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNamePrimaryImage);

                $product->update([
                    'primary_image' => $fileNamePrimaryImage
                ]);
                toastr()->warning('عملیات موفقیت آمیز بود', 'تصویر اصلی محصول ویرایش شد', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
            }

            if ($request->has('images')) {

                foreach ($request->images as $image) {
                    $fileNameImage = generateFileName($image->getClientOriginalName());

                    $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameImage
                    ]);
                }
                toastr()->warning('عملیات موفقیت آمیز بود', 'تصاویر محصول ویرایش شد', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            toastr()->error('عملیات ناموفق', 'تصویر  محصول ویرایش نشد', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
            return redirect()->back();
        }
        return redirect()->back();
    }

}
