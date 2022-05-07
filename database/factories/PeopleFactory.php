<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\DocumentType;
use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = People::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'document_number' => $this->faker->numerify(),
            'birth_date' => $this->faker->date(),
            'mobile_phone' => $this->faker->numerify(),
            'country_id' => 1,
            'document_type_id' => 1,
            'address' => $this->faker->address
        ];
    }
}
