<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateHomeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-home-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update home products for app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('products')
            ->whereNotNull('home_category_id')
            ->update(['home_category_id' => null]);

        $grandparents = Category::whereNull('parent_id')
            ->with('grandChildren')
            ->get();

        foreach ($grandparents as $grandparent) {
            Product::whereIn('category_id', $grandparent->grandChildren->pluck('id'))
                ->where('has_stock', 1)
                ->where('has_discount', 1)
                ->where('created_at', '>=', Carbon::now()->subMonths(2))
                ->inRandomOrder()
                ->take(6)
                ->update(['home_category_id' => $grandparent->id]);
        }

        return Command::SUCCESS;
    }
}
