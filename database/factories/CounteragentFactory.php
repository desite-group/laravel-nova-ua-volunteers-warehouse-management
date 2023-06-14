<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounteragentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Counteragent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'patronymic' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'recipient_organization' => $this->faker->name,
            'recipient_address' => $this->faker->address,
            'internal_comment' => $this->faker->company
        ];
    }
}
