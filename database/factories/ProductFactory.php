<?php

namespace Database\Factories;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Category;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categoriesCount = Category::count();
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'text' => $this->faker->text,
            'article' => $this->faker->randomNumber(),
            'category_id' => rand(0, $categoriesCount - 1),
            'purchase_price' => rand(10.00, 10000.00),
            'price' => rand(10.00, 10000.00),
            'is_active' => 1,

            'internal_comment' => $this->faker->text,
        ];
    }
}
