<?php

namespace DesiteGroup\LaravelWarehouseManagement;

use DesiteGroup\LaravelWarehouseManagement\Models\Category;
use DesiteGroup\LaravelWarehouseManagement\Nova\Category as NovaCategory;
use DesiteGroup\LaravelWarehouseManagement\Nova\Product as NovaProduct;
use DesiteGroup\LaravelWarehouseManagement\Nova\Counteragent as NovaCounteragent;
use DesiteGroup\LaravelWarehouseManagement\Nova\Application as NovaApplication;
use DesiteGroup\LaravelWarehouseManagement\Nova\Act as NovaAct;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class WarehouseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! class_exists('CreateWarehouseCategoriesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_warehouse_categories_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_categories_table.php'),
            ], 'migrations');
        }

        $this->app->booted(function () {

            Nova::resources([
                NovaCategory::class,
                NovaProduct::class,
                NovaCounteragent::class,
                NovaApplication::class,
                NovaAct::class,
            ]);
        });
    }
}
