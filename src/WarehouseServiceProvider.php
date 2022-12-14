<?php

namespace DesiteGroup\LaravelWarehouseManagement;

use DesiteGroup\LaravelWarehouseManagement\Models\Category;
use DesiteGroup\LaravelWarehouseManagement\Nova\Category as NovaCategory;
use Illuminate\Support\Facades\Gate;
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

        Nova::resourcesIn(__DIR__.'/Nova');

        $this->app->booted(function () {

            Nova::resources([
                NovaCategory::class,
            ]);

            $this->app->bind(Category::class, Category::class);
        });
    }
}
