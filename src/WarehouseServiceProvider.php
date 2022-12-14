<?php

namespace DesiteGroup\LaravelWarehouseManagement;

use DesiteGroup\LaravelWarehouseManagement\Models\Category;
use DesiteGroup\LaravelWarehouseManagement\Nova\Category as NovaCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class WarehouseServiceProvider extends ServiceProvider
{
    protected static $callbacks = [
        Category::class => ['booted' => null],
    ];

    protected $policies = [
        \DesiteGroup\LaravelWarehouseManagement\Models\Category::class => \DesiteGroup\LaravelWarehouseManagement\Policies\CategoryPolicy::class,
    ];

    public function boot()
    {
        if (! class_exists('CreateWarehouseCategoriesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_warehouse_categories_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_warehouse_categories_table.php'),
            ], 'migrations');
        }

        Nova::resourcesIn(__DIR__.'/Nova');

//        $this->app->booted(function () {
//
//            $mod = app(NovaCategory::class);
//            $final_class = get_class($mod);
//
//            Nova::resources([
//                $final_class,
//            ]);
//
//            $this->app->bind(Category::class, Category::class);
//        });

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        foreach ($this->policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    public function policies()
    {
        return $this->policies;
    }

    public static function setCallback($class, $hook, callable $cb)
    {
        if (!isset(self::$callbacks[$class])) {
            throw new \Exception("setCallback::{$class} not supported");
        }
        $cl = self::$callbacks[$class];
        if (!array_key_exists($hook, $cl)) {

            throw new \Exception("setCallback::{$class}::{$hook} not supported");
        }
        self::$callbacks[$class][$hook] = $cb;
    }
    public static function getCallback($class, $hook)
    {
        $default = function () {
        };
        if (!isset(self::$callbacks[$class])) {
            return $default;
        }
        $cl = self::$callbacks[$class];
        if (!isset($cl[$hook])) {
            return $default;
        }
        return $cl[$hook];
    }
}
