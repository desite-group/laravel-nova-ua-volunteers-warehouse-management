<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Checkpoint;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\CustomsDeclaration;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomsDeclaraionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomsDeclaration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $checkpointsCount = Checkpoint::count();
        $counteragentsCount = Counteragent::count();
        return [
            'declaration_person_id' => rand(0, $counteragentsCount - 1),
            'driver_id' => rand(0, $counteragentsCount - 1),
            'brand_of_car' => $this->faker->name,
            'licence_plate' => $this->faker->randomNumber(),
            'dispatcher' => $this->faker->company,
            'recipient' => $this->faker->company,
            'place_of_unloading' => $this->faker->address,
            'checkpoint_id' => rand(0, $checkpointsCount - 1),
            'date' => $this->faker->date,
        ];
    }
}
