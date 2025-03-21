<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'White', 'Grey', 'Black', 'Blue', 'Brown', 'Red', 'Khaki', 'Silver', 'Orange', 'Beige', 'Green', 'Yellow',
        ];
        $attribute = Attribute::create([
            'name' => 'Colors',
            'sort_order' => 1,
        ]);
        for ($j = 0; $j < count($colors); $j++) {
            AttributeValue::create([
                'attribute_id' => $attribute->id,
                'name' => $colors[$j],
                'sort_order' => 1,
            ]);
        }

        $sizes = [
            'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',
        ];
        $attribute = Attribute::create([
            'name' => 'Sizes',
            'sort_order' => 2
        ]);
        for ($j = 0; $j < count($sizes); $j++) {
            AttributeValue::create([
                'attribute_id' => $attribute->id,
                'name' => $sizes[$j],
                'sort_order' => $j + 1,
            ]);
        }
    }
}
