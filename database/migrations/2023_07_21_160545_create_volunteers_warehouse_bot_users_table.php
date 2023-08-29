<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseBotUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_users', function (Blueprint $table) {
            $table->id();
            $table->string('bot_user_id');
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->unique();
            $table->string('password')->nullable();
            $table->string('language_code')->nullable();
            $table->string('photo_url')->nullable();

            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('role_id')->default(1);
            $table->unsignedInteger('is_active')->default(0);
            $table->unsignedInteger('is_volunteer')->default(0);

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
        Schema::dropIfExists('bot_users');
    }
}
