<?php

namespace Database\Factories;

use App\Models\CustomerInformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone_no' => '011'.mt_rand(10000000,99999999),
            'age' => mt_rand(20,60),
            'user_id' => User::factory(['role_id' => '3'])
        ];
    }
}
