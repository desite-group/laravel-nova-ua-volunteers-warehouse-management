<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('text')->nullable();
            $table->string('article')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->decimal('purchase_price')->default(0.00)->nullable();
            $table->decimal('price')->default(0.00)->nullable();
            $table->tinyInteger('is_active')->default(1);

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
        Schema::dropIfExists('products');
    }
}
