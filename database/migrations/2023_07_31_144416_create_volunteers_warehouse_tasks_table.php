<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('bot_user_id');
            $table->unsignedInteger('author_bot_user_id');
            $table->dateTime('deadline')->nullable();
            $table->string('reminder')->nullable();
            $table->string('status')->default('new');
            $table->text('description')->nullable();
            $table->text('log')->nullable();

            $table->unsignedInteger('is_active')->default(1);
            $table->unsignedInteger('is_completed')->default(0);
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
        Schema::dropIfExists('tasks');
    }
}
