<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            'NIKE',
            'PUMA',
            'SKECHERS',
            'EMPORIO ARMANI',
            'MASSIMO DUTTI',
            'HUGO',
            'GUESS',
            'BOSS',
            'CALVIN KLEIN',
            'LACOSTE',
            'TOMMY HILFIGER',
            'ADIDAS',
            'BERSHKA',
            'BUGATTI',
            'COLUMBIA',
            'ECCO',
            'GANT',
            'HUMMEL',
            'JORDAN',
            "LEVI'S",
            'NEW BALANCE',
            'PULL & BEAR',
            'REEBOK',
            'THE NORTH FACE',
            'TIMBERLAND',
        ];

        foreach ($objs as $obj) {
            $brand = Brand::create([
                'name' => $obj,
                'slug' => str()->random(5),
            ]);
            $brand->slug = str($brand->name)->slug() . '-' . $brand->id;
            $brand->update();
        }
    }
}
