<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'is_active' => 1,

            'internal_comment' => $this->faker->text,
        ];
    }
}
