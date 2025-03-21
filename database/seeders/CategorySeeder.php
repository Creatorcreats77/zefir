<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            ['name' => 'Women', 'categories' => [
                ['name' => 'Clothing', 'categories' => [
                    'Jackets & coats', 'Dresses & jumpsuits', 'Sweaters & cardigans', 'Trousers & shorts', 'Jeans',
                    'Blouses', 'Skirts', 'Suits & blazers', 'T-shirts', 'Tracksuits & sweatshirts',
                ]],
                ['name' => 'Shoes', 'categories' => [
                    'Sneakers', 'Pumps', 'Boots', 'Flats', 'Sandals', 'Slides',
                ]],
                ['name' => 'Accessories', 'categories' => [
                    'Bags', 'Belts', 'Wallets', 'Watches', 'Glasses', 'Fragrances', 'Hats & gloves',
                    'Scarves', 'Jewellery', 'More accessories',
                ]],
            ]],
            ['name' => 'Men', 'categories' => [
                ['name' => 'Clothing', 'categories' => [
                    'Sweats & hoodies', 'Jackets & coats', 'Trousers & shorts', 'Jeans', 'Shirts', 'Suits & blazers',
                    'Tracksuits & sweatshirts', 'Polo shirts', 'T-shirts',
                ]],
                ['name' => 'Shoes', 'categories' => [
                    'Sneakers', 'Boots', 'Loafers & moccasins', 'Classic shoes', 'Slides & flip flops',
                ]],
                ['name' => 'Accessories', 'categories' => [
                    'Bags', 'Belts', 'Wallets', 'Watches', 'Hats & caps', 'Scarves', 'Glasses',
                    'Ties & pocket squares', 'Fragrances', 'Gloves', 'More accessories',
                ]],
            ]],
            ['name' => 'Kids', 'categories' => [
                ['name' => 'Boys', 'categories' => [
                    'Babies (age 0-3)', 'Juniors (age 4-14)', 'Tops', 'Bottoms', 'Shoes',
                ]],
                ['name' => 'Girls', 'categories' => [
                    'Babies (age 0-3)', 'Juniors (age 4-14)', 'Tops', 'Bottoms', 'Shoes',
                ]],
                ['name' => 'Accessories', 'categories' => [
                    'Accessories', 'Baby accessories', 'Hats & scarves',
                ]],
            ]],
        ];

        for ($i = 0; $i < count($objs); $i++) {
            $gender = $i + 1;

            $grandparent = Category::create([
                'gender_id' => $gender,
                'name' => $objs[$i]['name'],
                'slug' => str()->random(5),
                'sort_order' => $i + 1,
            ]);
            $grandparent->slug = str($grandparent->name)->slug() . '-' . $grandparent->id;
            $grandparent->update();

            for ($j = 0; $j < count($objs[$i]['categories']); $j++) {
                $parent = Category::create([
                    'gender_id' => $gender,
                    'parent_id' => $grandparent->id,
                    'name' => $objs[$i]['categories'][$j]['name'],
                    'slug' => str()->random(5),
                    'sort_order' => $j + 1,
                ]);
                $parent->slug = str($parent->name)->slug() . '-' . $parent->id;
                $parent->update();

                for ($k = 0; $k < count($objs[$i]['categories'][$j]['categories']); $k++) {
                    $category = Category::create([
                        'gender_id' => $gender,
                        'grandparent_id' => $grandparent->id,
                        'parent_id' => $parent->id,
                        'name' => $objs[$i]['categories'][$j]['categories'][$k],
                        'slug' => str()->random(5),
                        'sort_order' => $k + 1,
                    ]);
                    $category->slug = str($category->name)->slug() . '-' . $category->id;
                    $category->update();
                }
            }
        }
    }
}
