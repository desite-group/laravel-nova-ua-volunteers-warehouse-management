<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateVolunteersWarehouseLogBotMessagesTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_bot_messages', function (Blueprint $table) {
            $table->id();
            $table->string('bot_user_id');
            $table->text('message')->nullable();
            $table->string('page_class')->nullable();

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
        Schema::dropIfExists('log_bot_messages');
    }
}
