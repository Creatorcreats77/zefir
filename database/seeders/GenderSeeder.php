<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objs = [
            ['name' => 'Women', 'name_tm' => 'Aýal', 'name_ru' => 'Женщина'],
            ['name' => 'Men', 'name_tm' => 'Erkek', 'name_ru' => 'Мужчина'],
            ['name' => 'Kids', 'name_tm' => 'Çaga', 'name_ru' => 'Ребенок'],
        ];

        foreach ($objs as $obj) {
            $gender = Gender::create([
                'name' => $obj['name'],
                'name_tm' => $obj['name_tm'],
                'name_ru' => $obj['name_ru'],
                'slug' => str()->random(5),
            ]);
            $gender->slug = str($gender->name)->slug() . '-' . $gender->id;
            $gender->update();
        }
    }
}
