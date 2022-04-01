<?php

namespace Database\Seeders;

use App\Models\CustomerInformation;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StaffInformation;
use App\Models\SubProductCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            RoleHasPermissionSeeder::class,
            ProductCategorySeeder::class,
            SubProductCategorySeeder::class,
        ]);

        CustomerInformation::factory()->count(500)->create();
        StaffInformation::factory()->count(20)->create();
        Product::factory()->count(25)->create([
            'category_id' => ProductCategory::where('name', 'Shirts')->first()->id,
            'sub_category_id' => SubProductCategory::where('name', 'Men')->first()->id,
        ]);
        Product::factory()->count(25)->create([
            'category_id' => ProductCategory::where('name', 'Shirts')->first()->id,
            'sub_category_id' => SubProductCategory::where('name', 'Women')->first()->id,
        ]);
        Product::factory()->count(20)->create([
            'category_id' => ProductCategory::where('name', 'Trousers')->first()->id,
            'sub_category_id' => null,
        ]);
        Product::factory()->count(10)->create([
            'category_id' => ProductCategory::where('name', 'Sports')->first()->id,
            'sub_category_id' => null,
        ]);
        Product::factory()->count(5)->create([
            'category_id' => ProductCategory::where('name', 'Watches')->first()->id,
            'sub_category_id' => null,
        ]);
        Product::factory()->count(3)->create([
            'category_id' => ProductCategory::where('name', 'Beauty')->first()->id,
            'sub_category_id' => null,
        ]);
    }
}
