<?php

namespace Database\Seeders;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent;
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
        Counteragent::factory()->count(20)->create();
    }
}
