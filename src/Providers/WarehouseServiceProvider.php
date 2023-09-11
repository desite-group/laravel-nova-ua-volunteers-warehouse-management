<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Providers;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Console\Commands\BotTaskReminder;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Category as NovaCategory;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Product as NovaProduct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Counteragent as NovaCounteragent;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Application as NovaApplication;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Act as NovaAct;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotUser as NovaBotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\LogBotMessage as NovaLogBotMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotRole as NovaBotRole;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Loading as NovaLoading;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotPermission as NovaPermission;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Task as NovaTask;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Question as NovaQuestion;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\MeasurementUnit as NovaMeasurementUnit;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Checkpoint as NovaCheckpoint;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\CustomsDeclaration as NovaCustomsDeclaration;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Illuminate\Console\Scheduling\Schedule;

class WarehouseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../database/seeders/' => database_path('seeders/'),
        ], 'volunteers-warehouse-database');

        $this->publishes([
            __DIR__ . '/../../database/factories/' => database_path('factories/'),
        ], 'volunteers-warehouse-database');

        $this->commands([
            BotTaskReminder::class
        ]);

        $this->scheduler();
        $this->nova();
    }

    private function scheduler()
    {
        $this->app->booted(function () {
            $schedule = app(Schedule::class);

            $schedule->command('bot:task-reminder default')->everyMinute();

            $schedule->command('bot:task-reminder everyday')->dailyAt('10:30');

            $schedule->command('bot:task-reminder every_week')->weeklyOn(1, '10:30');

            $schedule->command('bot:task-reminder every_two_days')->weeklyOn(1, '10:30');
            $schedule->command('bot:task-reminder every_two_days')->weeklyOn(3, '10:30');
            $schedule->command('bot:task-reminder every_two_days')->weeklyOn(5, '10:30');
            $schedule->command('bot:task-reminder every_two_days')->weeklyOn(7, '10:30');

            $schedule->command('bot:task-reminder every_three_days')->weeklyOn(1, '10:30');
            $schedule->command('bot:task-reminder every_three_days')->weeklyOn(4, '10:30');
            $schedule->command('bot:task-reminder every_three_days')->weeklyOn(7, '10:30');

            $schedule->command('bot:task-reminder every_two_week')->twiceMonthly(1, 16, '10:30');

            $schedule->command('bot:task-reminder every_month')->monthlyOn(1, '10:30');
        });
    }

    private function nova()
    {
        $this->app->booted(function () {
            Nova::resources([
                NovaCategory::class,
                NovaProduct::class,
                NovaCounteragent::class,
                NovaApplication::class,
                NovaAct::class,
                NovaLogBotMessage::class,
                NovaBotUser::class,
                NovaBotRole::class,
                NovaLoading::class,
                NovaPermission::class,
                NovaQuestion::class,
                NovaTask::class,
                NovaMeasurementUnit::class,
                NovaCheckpoint::class,
                NovaCustomsDeclaration::class,
            ]);
        });
    }
}
