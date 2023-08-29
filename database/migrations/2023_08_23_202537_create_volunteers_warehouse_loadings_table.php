<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseLoadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loadings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('author_bot_user_id');
            $table->dateTime('datetime')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('bot_user_loading', function (Blueprint $table) {
            $table->unsignedInteger('bot_user_id');
            $table->unsignedInteger('loading_id');
            $table->unsignedInteger('is_confirmed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loadings');
        Schema::dropIfExists('bot_user_loading');
    }
}
