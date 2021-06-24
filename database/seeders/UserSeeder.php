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
        DB::table('personal_informations')->insert([
            [
                'name' => 'Admin',
                'identity_no' => '950201015501',
                'phone_no' => '01111234566',
                'age' => '26',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test Staff',
                'identity_no' => '950201015501',
                'phone_no' => '01111234566',
                'age' => '26',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test Customer',
                'identity_no' => '950201015501',
                'phone_no' => '01111234566',
                'age' => '26',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('users')->insert([
            [
                'user_no' => 'ADMN'.Carbon::now()->format('Y').Carbon::now()->format('m').'00001',
                'name' => 'Admin',
                'email' => 'admin@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '1',
                'info_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_no' => 'STAF'.Carbon::now()->format('Y').Carbon::now()->format('m').'00001',
                'name' => 'Test Staff',
                'email' => 'teststaff@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '2',
                'info_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_no' => 'CUST'.Carbon::now()->format('Y').Carbon::now()->format('m').'00001',
                'name' => 'Test Customer',
                'email' => 'testcustomer@webshop.com',
                'password' => Hash::make('password'),
                'role_id' => '3',
                'info_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
