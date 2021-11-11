<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\StaffInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StaffInformation::class;

    public $number = 2;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'staff_no' => 'STAFF'.Carbon::now()->format('Y').Carbon::now()->format('m').sprintf('%05d', $this->number++),
            'name' => $this->faker->name(),
            'phone_no' => '011'.mt_rand(10000000,99999999),
            'age' => mt_rand(20,60),
            'user_id' => User::factory(['role_id' => '3'])
        ];
    }
}
