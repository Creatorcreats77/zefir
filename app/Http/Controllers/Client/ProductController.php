<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'gender' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'colors' => 'nullable|array|min:0',
            'colors.*' => 'nullable|integer|min:1',
            'sizes' => 'nullable|array|min:0',
            'sizes.*' => 'nullable|integer|min:1',
            'sortBy' => 'nullable|in:random,newToOld,lowToHigh,highToLow',
        ]);

        $f_gender = $request->has('gender') ? $request->gender : null;
        $f_category = $request->has('category') ? $request->category : null;
        $f_brand = $request->has('brand') ? $request->brand : null;
        $f_colors = $request->has('colors') ? $request->colors : [];
        $f_sizes = $request->has('sizes') ? $request->sizes : [];
        $f_sortBy = $request->has('sortBy') ? $request->sortBy : null;

        $gender = isset($f_gender) ? Gender::where('slug', $f_gender)->firstOrFail() : null;
        $category = isset($f_category) ? Category::where('slug', $f_category)->firstOrFail() : null;
        $categories = [];
        if (isset($f_category)) {
            if (isset($category->grandparent_id)) { // branch 3
                $categories = [$category->id];

            } elseif (isset($category->parent_id)) { // branch 2
                $categories = Category::where('parent_id', $category->id)
                    ->get()
                    ->pluck('id')
                    ->toArray();
            } else { // branch 1
                $categories = Category::where('grandparent_id', $category->id)
                    ->get()
                    ->pluck('id')
                    ->toArray();
            }
        }
        $brand = isset($f_brand) ? Brand::where('slug', $f_brand)->firstOrFail() : null;

        $products = Product::when(isset($f_gender), function ($query) use ($gender) {
            return $query->where('gender_id', $gender->id);
        })
            ->when(isset($f_category), function ($query) use ($categories) {
                return $query->whereIn('category_id', $categories);
            })
            ->when(isset($f_brand), function ($query) use ($brand) {
                return $query->where('brand_id', $brand->id);
            })
            ->when(count($f_colors) > 0, function ($query) use ($f_colors) {
                return $query->whereIn('color_id', $f_colors);
            })
            ->when(count($f_sizes) > 0, function ($query) use ($f_sizes) {
                return $query->whereHas('variants', function ($query) use ($f_sizes) {
                    $query->whereIn('size_id', $f_sizes);
                });
            })
            ->with('brand', 'category')
            ->when(isset($f_sortBy), function ($query) use ($f_sortBy) {
                if ($f_sortBy == 'newToOld') {
                    return $query->orderBy('id', 'desc');
                } elseif ($f_sortBy == 'lowToHigh') {
                    return $query->orderBy('discounted_price')
                        ->orderBy('id', 'desc');
                } elseif ($f_sortBy == 'highToLow') {
                    return $query->orderBy('discounted_price', 'desc')
                        ->orderBy('id', 'desc');
                } else {
                    return $query->orderBy('random')
                        ->orderBy('id', 'desc');
                }
            }, function ($query) {
                return $query->orderBy('random')
                    ->orderBy('id', 'desc'); // desc => Z-A, asc => A-Z
            })
            ->paginate(40)
            ->withQueryString();

        $genders = Gender::orderBy('id')
            ->get();
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

        return view('client.products.index')
            ->with([
                'products' => $products,
                'gender' => $gender,
                'category' => $category,
                'brand' => $brand,
                'genders' => $genders,
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors,
                'sizes' => $sizes,
                'f_gender' => $f_gender,
                'f_category' => $f_category,
                'f_brand' => $f_brand,
                'f_colors' => $f_colors,
                'f_sizes' => $f_sizes,
                'f_sortBy' => $f_sortBy,
            ]);
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('brand', 'category')
            ->firstOrFail();
        $product->increment('viewed');

        $colors = Product::where('group_id', $product->group_id)
            ->with('color')
            ->get();

        $sizes = Variant::where('product_id', $product->id)
            ->with('size')
            ->get();

        $similar = Product::whereNot('id', $product->id)
            ->where('category_id', $product->category_id)
            ->with('brand', 'category')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('client.products.show')
            ->with([
                'product' => $product,
                'colors' => $colors,
                'sizes' => $sizes,
                'similar' => $similar,
            ]);
    }
}
