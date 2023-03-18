<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Providers;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Category as NovaCategory;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Product as NovaProduct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Counteragent as NovaCounteragent;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Application as NovaApplication;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Act as NovaAct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Request as NovaRequest;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\MeasurementUnit as NovaMeasurementUnit;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Checkpoint as NovaCheckpoint;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\CustomsDeclaration as NovaCustomsDeclaration;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class WarehouseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishResources();
        $this->app->booted(function () {

            Nova::resources([
                NovaCategory::class,
                NovaProduct::class,
                NovaCounteragent::class,
                NovaApplication::class,
                NovaAct::class,
                NovaRequest::class,
                NovaMeasurementUnit::class,
                NovaCheckpoint::class,
                NovaCustomsDeclaration::class,
            ]);
        });
    }

    protected function publishResources()
    {

        //TODO will be better to use $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if (! class_exists('CreateVolunteersWarehouseCategoriesTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_categories_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_categories_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseProductsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_products_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_products_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseCounteragentsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_counteragents_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_counteragents_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseApplicationsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_applications_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_applications_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateWarehouseActsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_acts_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_acts_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateVolunteersWarehouseRequestsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_volunteers_warehouse_requests_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_volunteers_warehouse_requests_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateMeasurementUnitsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_measurement_units_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_measurement_units_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateCheckpointsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_checkpoints_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_checkpoints_table.php'),
            ], 'migrations');
        }


        if (! class_exists('CreateCustomsDeclarationsTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_customs_declarations_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_customs_declarations_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CreateCustomsDeclarationProductTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_customs_declaration_product_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_customs_declaration_product_table.php'),
            ], 'migrations');
        }

        if (! class_exists('CheckpointsSeeder')) {
            $this->publishes([
                __DIR__ . '/../../database/seeders/CheckpointsSeeder.php' => database_path('seeders/CheckpointsSeeder.php'),
            ], 'seeders');
        }
    }
}
