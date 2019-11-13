<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('slide_id');                                    // 幻灯片id
            $table->tinyInteger('status')->default(0);              // 状态,1:显示;0:隐藏
            $table->float('list_order')->default(0);                // 排序
            $table->string('title',50);                             // 幻灯片名称
            $table->string('image',255)->default('');         // 幻灯片图片
            $table->string('url',255)->default('');           // 幻灯片链接
            $table->string('description',255)->default('');   // 幻灯片描述
            $table->text('content');                                        // 幻灯片内容
            $table->text('more');                                           // 扩展信息
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
        Schema::dropIfExists('slide_item');
    }
}
