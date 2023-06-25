<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Act;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Act::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $counteragentsCount = Counteragent::count();
        $applicationsCount = Application::count();
        return [
            'document_number' => $this->faker->randomNumber(),

            'driver_name' => $this->faker->firstName,
            'driver_surname' => $this->faker->lastName,
            'driver_patronymic' => $this->faker->name,

            'car_info' => $this->faker->name,
            'license_plate' => $this->faker->name,
            'description' => $this->faker->text,

            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'patronymic' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,

            'recipient_organization' => $this->faker->company,
            'recipient_address' => $this->faker->address,

            'counteragent_id' => rand(0, $counteragentsCount -1),
            'application_id' => rand(0, $applicationsCount -1),

            'internal_comment' => $this->faker->randomNumber(),
        ];
    }
}
