<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalCategoriesTable extends Migration
{
    /** 这个表用来对任务分类用，暂时没有其他用途
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100)->comment('名称');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('用户目标分类');
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
        Schema::dropIfExists('goal_categories');
    }
}
