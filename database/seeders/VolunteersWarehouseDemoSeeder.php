<?php

namespace Database\Seeders;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Act;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Category;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\CustomsDeclaration;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\MeasurementUnit;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Product;
use Illuminate\Database\Seeder;

class VolunteersWarehouseDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(20)->create();
        Product::factory()->count(100)->create();
        Counteragent::factory()->count(20)->create();
        CustomsDeclaration::factory()->count(20)->create();
        $this->addCustomsDeclarationProducts();
        Application::factory()->count(20)->create();
        Act::factory()->count(20)->create();
    }

    private function addCustomsDeclarationProducts(int $count = 10)
    {
        $customsDeclarations = CustomsDeclaration::get();
        $products = Product::get();
        $measurementUnits = MeasurementUnit::get();

        foreach ($customsDeclarations as $customsDeclaration) {
            for ($i = 0; $i < $count; $i++) {
                $customsDeclaration->products()->attach([
                    $products->random()->getAttribute('id') => [
                        'measurement_unit_id' => $measurementUnits->random()->getAttribute('id'),
                        'quantity' => rand(1.00, 100.00)
                    ]
                ]);
            }
        }
    }
}
