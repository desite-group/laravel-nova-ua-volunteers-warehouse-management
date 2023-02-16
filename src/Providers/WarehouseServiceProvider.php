<?php

namespace DesiteGroup\LaravelNovaWarehouseManagement\Providers;

use DesiteGroup\LaravelNovaWarehouseManagement\Nova\Category as NovaCategory;
use DesiteGroup\LaravelNovaWarehouseManagement\Nova\Product as NovaProduct;
use DesiteGroup\LaravelNovaWarehouseManagement\Nova\Counteragent as NovaCounteragent;
use DesiteGroup\LaravelNovaWarehouseManagement\Nova\Application as NovaApplication;
use DesiteGroup\LaravelNovaWarehouseManagement\Nova\Act as NovaAct;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class WarehouseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! class_exists('CreateWarehouseCategoriesTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_warehouse_categories_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_categories_table.php'),
           ], 'migrations');
        }

        if (! class_exists('CreateWarehouseProductsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_warehouse_products_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_products_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseCounteragentsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_warehouse_counteragents_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_counteragents_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseApplicationsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_warehouse_applications_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_applications_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseActsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_warehouse_acts_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_acts_table.php'),
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
