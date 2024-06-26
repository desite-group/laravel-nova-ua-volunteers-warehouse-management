<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');

            $table->string('driver_name')->nullable();
            $table->string('driver_surname')->nullable();
            $table->string('driver_patronymic')->nullable();

            $table->string('car_info')->nullable();
            $table->string('license_plate')->nullable();
            $table->text('description')->nullable();

            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('phone')->nullable();

            $table->string('recipient_organization')->nullable();
            $table->string('recipient_address')->nullable();

            $table->unsignedInteger('counteragent_id')->nullable();
            $table->unsignedInteger('application_id')->nullable();

            $table->text('internal_comment')->nullable();

            $table->integer('sort_order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acts');
    }
}
