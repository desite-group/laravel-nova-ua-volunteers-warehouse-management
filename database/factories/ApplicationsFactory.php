<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ['organization', 'military_personnel', 'personal'];
        $needs = ['military', 'injured', 'civilian_displaced'];
        return [
            'document_number' => $this->faker->randomNumber(),

            'organization' => $this->faker->company,
            'organization_address' => $this->faker->address,
            'organization_chief_name' => $this->faker->firstName,
            'organization_chief_surname' => $this->faker->lastName,
            'organization_chief_patronymic' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'recipient' => $this->faker->firstName .' '. $this->faker->lastName,

            'additional_text' => $this->faker->text,

            'internal_comment' => $this->faker->text,

            'type' => $types[rand(0,2)],
            'needs' => $needs[rand(0,2)],
        ];
    }
}
