<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 250; $i++) {
            $user = User::where('is_admin', 0)->inRandomOrder()->first();
            $category = Category::whereNotNull('grandparent_id')->inRandomOrder()->first();
            $brand = Brand::inRandomOrder()->first();
            $groupId = str()->random(10);
            $productName = fake()->unique()->streetName();
            $price = fake()->numberBetween(111, 999);
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');

            $colors = [];
            for ($j = 0; $j < rand(3, 5); $j++) {
                $color = AttributeValue::where('attribute_id', 1)->whereNotIn('id', $colors)->inRandomOrder()->first();
                $colors[] = $color->id;
                $productId = $groupId . '-' . str($color->name)->slug();
                $productName = $color->name . ' ' . $productName;
                $hasDiscount = fake()->boolean(20);

                $product = Product::create([
                    'user_id' => $user->id,
                    'gender_id' => $category->gender_id,
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'color_id' => $color->id,
                    'group_id' => $groupId,
                    'product_id' => $productId,
                    'name' => $productName,
                    'slug' => str()->random(5),
                    'description' => fake()->paragraph(rand(1, 3)),
                    'discounted_price' => $hasDiscount ? $price - fake()->numberBetween(1, 99) : $price,
                    'selling_price' => $price,
                    'has_discount' => $hasDiscount,
                    'has_stock' => 1,
                    'viewed' => fake()->numberBetween(1, 999),
                    'random' => fake()->numberBetween(1, 9999),
                    'created_at' => Carbon::parse($createdAt),
                    'updated_at' => Carbon::parse($createdAt)->addDays(rand(0, 7)),
                ]);
                $product->slug = str($product->name)->slug() . '-' . $product->id;
                $product->update();

                $sizes = [];
                for ($k = 0; $k < rand(3, 5); $k++) {
                    $size = AttributeValue::where('attribute_id', 2)->whereNotIn('id', $sizes)->inRandomOrder()->first();
                    $sizes[] = $size->id;
                    $variantId = $productId . '-' . str($size->name)->slug();

                    Variant::create([
                        'product_id' => $product->id,
                        'size_id' => $size->id,
                        'variant_id' => $variantId,
                        'stock' => rand(0, 3),
                        'created_at' => Carbon::parse($createdAt),
                        'updated_at' => Carbon::parse($createdAt)->addDays(rand(0, 7)),
                    ]);
                }
            }
        }
    }
}
