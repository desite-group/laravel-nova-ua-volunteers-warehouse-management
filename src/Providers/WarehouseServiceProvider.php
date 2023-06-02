<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Providers;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Category as NovaCategory;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Product as NovaProduct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Counteragent as NovaCounteragent;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Application as NovaApplication;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Act as NovaAct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\IncomingRequest as NovaRequest;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\MeasurementUnit as NovaMeasurementUnit;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Checkpoint as NovaCheckpoint;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\CustomsDeclaration as NovaCustomsDeclaration;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class WarehouseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'volunteers_warehouse');

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
}
