# Laravel Nova Warehouse Management
A simple package for an online store, for managing orders and warehouse. Based on Laravel Nova

# Installation

You can install the package via composer:

    composer require desite-group/laravel-warehouse-management

You need to publish the migration to create tables:

    php artisan vendor:publish --provider="DesiteGroup\LaravelWarehouseManagement\WarehouseServiceProvider" --tag="migrations"

After that, you need to run migrations.

    php artisan migrate
