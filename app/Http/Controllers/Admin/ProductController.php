<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductVariationController;
//use App\Http\Controllers\Admin\ProductAttributeController;
//use App\Http\Controllers\Admin\ProductImageController;
//use App\Http\Controllers\Admin\ProductVariationController;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;
use Exception;
use Wavey\Sweetalert\Sweetalert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::where('parent_id', '!=', 0)->get();

        return view('admin.products.create', compact('categories', 'tags', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'brand_id' => 'required',
            'is_active' => 'required|in:0,1',
            'tag_ids' => 'required',
            'description' => 'required',
            'primary_image' => 'required|mimes:jpg,jpeg,svg,png,gif,webp',
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,svg,png,gif,webp',
            'category_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer|min:0',
            'variation_values.quantity.*' => 'integer|min:0',
            'delivery_amount' => 'required|integer|min:0',
            'delivery_amount_per_product' => 'nullable|integer|min:0',

        ]);

        try {
            DB::beginTransaction();


            $ProductImageController = new ProductImageController();
            $fileNameImages = $ProductImageController->upload($request->primary_image, $request->images);

//
            $product = Product::create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'primary_image' => $fileNameImages['fileNamePrimaryImage'],
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,

            ]);

            foreach ($fileNameImages['fileNameImages'] as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage,
                ]);
            }

//
            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->store($request->attribute_ids, $product);


            $category = Category::find($request->category_id);

            $ProductVariationController = new ProductVariationController();
            $ProductVariationController->store($request->variation_values, $category->attributes()->wherePivot('is_variation', 1)->first()->id, $product);

            $product->tags()->attach($request->tag_ids);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            toastr()->error('مشکل در ایجاد محصول', $exception->getMessage(), ['positionClass' => 'toast-top-center']);
            return redirect()->back();
        }

        toastr()->success('محصول جدیدی ایجاد شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
        return redirect()->route('admin.products.index');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $productAttributes = $product->attributes()->with('attribute')->get();
        $productVariations = $product->variations;
        $images = $product->images;

        return view('admin.products.show', compact('product', 'productAttributes', 'productVariations', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $productAttributes = $product->attributes()->with('attribute')->get();
        $productVariations = $product->variations;
        return view('admin.products.edit', compact('product', 'brands', 'tags', 'productAttributes', 'productVariations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required|in:0,1',
            'tag_ids' => 'required',
            'tag_ids.*' => 'exists:tags,id',
            'description' => 'required',
            'attribute_values' => 'required',
            'variation_values' => 'required',
            'variation_values.*.price' => 'required|integer',
            'variation_values.*.quantity' => 'required|integer',
            'variation_values.*.sale_price' => 'nullable|integer',
            'variation_values.*.date_on_sale_from' => 'nullable|date',
            'variation_values.*.date_on_sale_to' => 'nullable|date',
            'delivery_amount' => 'required|integer|min:0',
            'delivery_amount_per_product' => 'nullable|integer|min:0',

        ]);

        try {
            DB::beginTransaction();

            $product->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,

            ]);

            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->update($request->attribute_values);


            $ProductVariationController = new ProductVariationController();
            $ProductVariationController->update($request->variation_values);
//
            $product->tags()->sync($request->tag_ids);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            toastr()->error('مشکل در ویرایش محصول', $exception->getMessage(), ['positionClass' => 'toast-top-center']);
            return redirect()->back();
        }

        toastr()->info('محصول مورد نظر ویرایش شد', 'عملیات موفقیت آمیز بود', ['timeOut' => 1800, 'positionClass' => 'toast-top-center']);
        return redirect()->route('admin.products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function editCategory(Request $request, Product $product)
    {
        $categories = Category::where('parent_id', '!=', 0)->get();
        return view('admin.products.edit_category', compact('product' , 'categories'));
    }

    public function updateCategory(Request $request, Product $product)
    {
        // dd($request->all());
        $request->validate([
            'category_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer'
        ]);
        try {
            DB::beginTransaction();

            $product->update([
                'category_id' => $request->category_id
            ]);

            $productAttributeController = new ProductAttributeController();
            $productAttributeController->change($request->attribute_ids, $product);

            $category = Category::find($request->category_id);
            $productVariationController = new ProductVariationController();
            $productVariationController->change($request->variation_values, $category->attributes()->wherePivot('is_variation', 1)->first()->id, $product);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            toastr()->error('مشکل در ایجاد محصول', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        toastr()->success('محصول مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.products.index');
    }
}
