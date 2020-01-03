<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->comment('名称');
            $table->integer('mission_amount')->comment('任务总数');
            $table->integer('mission_accomplish_amount')->comment('完成任务总数');
            $table->unsignedInteger('weekly_plan_id')->nullable();
            $table->tinyInteger('is_done')->default(0)->comment('是否完成');
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
        Schema::dropIfExists('missions');
    }
}
