<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteersWarehouseApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');

            $table->text('organization')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('organization_chief_name')->nullable();
            $table->string('organization_chief_surname')->nullable();
            $table->string('organization_chief_patronymic')->nullable();

            $table->string('recipient')->nullable();
            $table->string('phone')->nullable();

            $table->text('additional_text')->nullable();

            $table->text('internal_comment')->nullable();

            $table->enum('type', ['organization', 'military_personnel', 'personal'])->nullable();
            $table->enum('needs', ['military', 'injured', 'civilian_displaced'])->nullable();

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
        Schema::dropIfExists('applications');
    }
}
