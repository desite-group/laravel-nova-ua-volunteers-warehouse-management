<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseCustomsDeclarationProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_declaration_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customs_declaration_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity')->default(0.00)->nullable();
            $table->unsignedBigInteger('measurement_unit_id');
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
        Schema::dropIfExists('customs_declaration_product');
    }
}
