<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',50)->comment('标题');
            $table->tinyInteger('reward_type')->index()->default(1)->comment('奖励类型');
            $table->unsignedTinyInteger('amount')->default(0)->comment('奖励数量');
            $table->string('image',100)->nullable()->comment('图片');
            $table->timestamp('start_at')->nullable()->comment('开始时间');
            $table->timestamp('fail_at')->nullable()->comment('失败时间，挑战失败');
            $table->timestamp('end_at')->nullable()->comment('结束时间');
            $table->timestamp('obtain_at')->nullable()->comment('获取时间');
            $table->timestamp('cancel_at')->nullable()->comment('取消时间，取消意味着不能再领取');
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
        Schema::dropIfExists('rewards');
    }
}
