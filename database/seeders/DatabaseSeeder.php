<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Admin',
                'username' => 'admin',
                'is_admin' => 1,
            ]);
        User::factory()
            ->count(10)
            ->create();

        $this->call([
            GenderSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            AttributeValueSeeder::class,
            ProductVariantSeeder::class,
        ]);

        Artisan::call('app:update-home-products');
    }
}
