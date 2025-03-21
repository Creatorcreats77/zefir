<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'user' => 'nullable|integer|min:1',
            'gender' => 'nullable|integer|min:1',
            'category' => 'nullable|integer|min:1',
            'brand' => 'nullable|integer|min:1',
            'color' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ]);
        $f_user = $request->has('user') ? $request->user : null;
        $f_gender = $request->has('gender') ? $request->gender : null;
        $f_category = $request->has('category') ? $request->category : null;
        $f_brand = $request->has('brand') ? $request->brand : null;
        $f_color = $request->has('color') ? $request->color : null;
        $f_size = $request->has('size') ? $request->size : null;

        $objs = Product::onlyOwner()
            ->when(isset($f_user), function ($query) use ($f_user) {
                return $query->where('user_id', $f_user);
            })
            ->when(isset($f_gender), function ($query) use ($f_gender) {
                return $query->where('gender_id', $f_gender);
            })
            ->when(isset($f_category), function ($query) use ($f_category) {
                return $query->where('category_id', $f_category);
            })
            ->when(isset($f_brand), function ($query) use ($f_brand) {
                return $query->where('brand_id', $f_brand);
            })
            ->when(isset($f_color), function ($query) use ($f_color) {
                return $query->where('color_id', $f_color);
            })
            ->when(isset($f_size), function ($query) use ($f_size) {
                return $query->whereHas('variants', function ($query) use ($f_size) {
                    $query->whereIn('size_id', $f_size);
                });
            })
            ->orderBy('id', 'desc')
            ->with('user', 'gender', 'category', 'brand', 'color', 'variants.size')
            ->paginate()
            ->withQueryString();

        return view('admin.products.index')
            ->with([
                'objs' => $objs,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children.children')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $brands = Brand::orderBy('name')
            ->get();
        $colors = AttributeValue::where('attribute_id', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $sizes = AttributeValue::where('attribute_id', 2)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.create')
            ->with([
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors,
                'sizes' => $sizes,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|integer|min:1',
            'brand' => 'required|integer|min:1',
            'color' => 'required|integer|min:1',
            'group_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:25500',
            'discounted_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'sizes' => 'required|array|min:0',
            'sizes.*' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:width=1000,height=1000',
        ]);

        $category = Category::findOrFail($request->category);
        $brand = Brand::findOrFail($request->brand);
        $color = AttributeValue::where('attribute_id', 1)->findOrFail($request->color);
        $discountedPrice = round($request->discounted_price, 1);
        $sellingPrice = round($request->selling_price, 1);

        $obj = Product::create([
            'user_id' => auth()->id(),
            'gender_id' => $category->gender_id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'color_id' => $color->id,
            'group_id' => $request->group_id,
            'product_id' => $request->group_id . '-' . str($color->name)->slug(),
            'name' => $request->name,
            'slug' => str()->random(5),
            'description' => $request->description,
            'discounted_price' => $discountedPrice,
            'selling_price' => $sellingPrice,
            'has_discount' => $sellingPrice > $discountedPrice ? 1 : 0,
            'has_stock' => 1,
        ]);

        $obj->slug = str($obj->name)->slug() . '-' . $obj->id;
        $obj->update();

        foreach ($request->sizes as $size) {
            $size = AttributeValue::where('attribute_id', 2)->findOrFail($size);
            $variantId = $obj->product_id . '-' . str($size->name)->slug();

            Variant::create([
                'product_id' => $obj->id,
                'size_id' => $size->id,
                'variant_id' => $variantId,
                'stock' => 1,
            ]);
        }

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = str()->random(5) . '.' . $request->file()->extension();
            Storage::put('public/product/' . $imageName, $image);

            $obj->image = 'product/' . $imageName;
            $obj->update();
        }

        return to_route('admin.products.index')
            ->with([
                'success' => trans('app.product') . ' ' . trans('app.added'),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obj = Product::onlyOwner()
            ->findOrFail($id);
        $categories = Category::whereNull('parent_id')
            ->with('children.children')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $brands = Brand::orderBy('name')
            ->get();
        $colors = AttributeValue::where('attribute_id', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $sizes = AttributeValue::where('attribute_id', 2)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.edit')
            ->with([
                'obj' => $obj,
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors,
                'sizes' => $sizes,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|integer|min:1',
            'brand' => 'required|integer|min:1',
            'color' => 'required|integer|min:1',
            'group_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:25500',
            'discounted_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'sizes' => 'required|array|min:0',
            'sizes.*' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:width=1000,height=1000',
        ]);

        $category = Category::findOrFail($request->category);
        $brand = Brand::findOrFail($request->brand);
        $color = AttributeValue::where('attribute_id', 1)->findOrFail($request->color);
        $discountedPrice = round($request->discounted_price, 1);
        $sellingPrice = round($request->selling_price, 1);

        $obj = Product::onlyOwner()
            ->findOrFail($id);
        $obj->gender_id = $category->gender_id;
        $obj->category_id = $category->id;
        $obj->brand_id = $brand->id;
        $obj->color_id = $color->id;
        $obj->group_id = $request->group_id;
        $obj->product_id = $request->group_id . '-' . str($color->name)->slug();
        $obj->name = $request->name;
        $obj->slug = str()->random(5);
        $obj->description = $request->description;
        $obj->discounted_price = $discountedPrice;
        $obj->selling_price = $sellingPrice;
        $obj->has_discount = $sellingPrice > $discountedPrice ? 1 : 0;
        $obj->has_stock = 1;
        $obj->update();

        $obj->slug = str($obj->name)->slug() . '-' . $obj->id;
        $obj->update();

        Variant::where('product_id', $obj->id)
            ->update(['stock' => 0]);

        foreach ($request->sizes as $size) {
            $size = AttributeValue::where('attribute_id', 2)->findOrFail($size);
            $variantId = $obj->product_id . '-' . str($size->name)->slug();

            Variant::updateOrCreate([
                'product_id' => $obj->id,
                'size_id' => $size->id,
            ], [
                'variant_id' => $variantId,
                'stock' => 1,
            ]);
        }

        if ($request->hasfile('image')) {
            if (isset($obj->image)) {
                Storage::delete($obj->image);
            }

            $image = $request->file('image');
            $imageName = str()->random(5) . '.' . $request->file()->extension();
            Storage::put('public/product/' . $imageName, $image);

            $obj->image = 'product/' . $imageName;
            $obj->update();
        }

        return to_route('admin.products.index')
            ->with([
                'success' => trans('app.product') . ' ' . trans('app.updated'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obj = Product::onlyOwner()
            ->findOrFail($id);
        if (isset($obj->image)) {
            Storage::delete($obj->image);
        }
        $obj->delete();

        return to_route('admin.products.index')
            ->with([
                'success' => trans('app.product') . ' ' . trans('app.deleted'),
            ]);
    }
}
