<?php

namespace Database\Factories;

use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonalInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'identity_no' => sprintf('%02d', mt_rand(00,80)).sprintf('%02d', mt_rand(01,12)).sprintf('%02d', mt_rand(01,30)).'01'.mt_rand(1000,9999),
            'phone_no' => '011'.mt_rand(10000000,99999999),
            'age' => mt_rand(20,60),
        ];
    }
}
