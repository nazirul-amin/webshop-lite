<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::firstOrCreate(
            [
                'name' => 'Shirts',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Trousers',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Jewellery',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Sports',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Watches',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Bags',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        ProductCategory::firstOrCreate(
            [
                'name' => 'Beauty',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
