<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test Staff',
                'email' => 'teststaff@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test Customer',
                'email' => 'testcustomer@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('staff_informations')->insert([
            [
                'staff_no' => 'ADMN'.Carbon::now()->format('Y').Carbon::now()->format('m').'00001',
                'name' => 'Admin',
                'phone_no' => '01111234566',
                'age' => '26',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'staff_no' => 'STAF'.Carbon::now()->format('Y').Carbon::now()->format('m').'00001',
                'name' => 'Test Staff',
                'phone_no' => '01111234566',
                'age' => '26',
                'user_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('customer_informations')->insert([
            [
                'name' => 'Test Customer',
                'phone_no' => '01111234566',
                'age' => '26',
                'user_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
