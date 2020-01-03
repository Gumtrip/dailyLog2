<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('mission_id');
            $table->string('description',150)->nullable()->comment('描述');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('properties')->nullable();
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
        Schema::dropIfExists('mission_logs');
    }
}
