<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseBotPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('bot_roles')->truncate();
        Schema::create('bot_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('bot_permission_bot_role', function (Blueprint $table) {
            $table->unsignedInteger('bot_permission_id');
            $table->unsignedInteger('bot_role_id');
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
        Schema::dropIfExists('bot_permissions');
        Schema::dropIfExists('bot_permission_bot_role');
    }
}
