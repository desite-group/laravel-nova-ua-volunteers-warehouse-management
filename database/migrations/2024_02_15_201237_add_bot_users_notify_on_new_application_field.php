<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBotUsersNotifyOnNewApplicationField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_users', function (Blueprint $table) {
            $table->unsignedInteger('notify_on_new_application')->default(0)->after('is_volunteer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bot_users', function (Blueprint $table) {
            $table->dropColumn('notify_on_new_application');
        });
    }
}
