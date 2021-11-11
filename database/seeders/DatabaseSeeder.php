<?php

namespace Database\Seeders;

use App\Models\CustomerInformation;
use App\Models\Product;
use App\Models\StaffInformation;
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
        ]);

        CustomerInformation::factory()->count(500)->create();
        StaffInformation::factory()->count(20)->create();
        Product::factory()->count(50)->create();
    }
}
