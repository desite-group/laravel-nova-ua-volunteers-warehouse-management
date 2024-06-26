<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseCustomsDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_declarations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('declaration_person_id');
            $table->unsignedBigInteger('driver_id');
            $table->string('brand_of_car');
            $table->string('licence_plate');
            $table->string('dispatcher');
            $table->string('recipient');
            $table->string('place_of_unloading');
            $table->unsignedBigInteger('checkpoint_id');
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customs_declarations');
    }
}
