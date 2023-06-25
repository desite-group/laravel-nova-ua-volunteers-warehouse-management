# Laravel Nova UA Volunteers Warehouse Management
A simple package for an online store, for managing orders and warehouse. Based on Laravel Nova

# Installation

You can install the package via composer:

    composer require desite-group/laravel-nova-ua-volunteers-warehouse-management

After that, you need to run migrations.

    php artisan migrate

You need to publish database data

    php artisan vendor:publish --tag=volunteers-warehouse-database

You need to seed base data

    php artisan db:seed --class=VolunteersWarehouseBaseSeeder

Also, you can seed demo data

    php artisan db:seed --class=VolunteersWarehouseDemoSeeder
