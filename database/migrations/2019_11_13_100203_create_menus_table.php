<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nav_id')->default(0);              // 导航 id
            $table->integer('parent_id')->default(0);           // 父 id
            $table->tinyInteger('status')->default(1);          // 状态;1:显示;0:隐藏
            $table->float('list_order')->default(0);            // 排序
            $table->string('name',50);                          // 菜单名称
            $table->string('href',100)->default('');      // 链接
            $table->tinyInteger('target')->default(0);          // 打开方式
            $table->string('icon')->default('');                 // 图标
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
        Schema::dropIfExists('menus');
    }
}
