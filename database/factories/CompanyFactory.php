<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company.' '.$this->faker->companySuffix,
            'address' => $this->faker->address,
            'website' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
