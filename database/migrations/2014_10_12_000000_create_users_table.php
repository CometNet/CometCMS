<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');                                     // 会员名称
            $table->string('account')->unique();                        // 会员账号
            $table->string('email')->unique();                          // 会员邮箱
            $table->timestamp('email_verified_at')->nullable();         // 邮箱验证时间
            $table->string('password');                                 // 密码
            $table->string('api_token', 60)->unique();          // api登录 token
            $table->tinyInteger('sex')->nullable();                     // 性别
            $table->timestamp('birthday')->nullable();                    // 生日
            $table->tinyInteger('status')->default(1)->nullable();// 用户状态 0:禁用,1:正常,2:未验证
            $table->string('avatar',255)->nullable();           // 头像
            $table->string('mobile',20)->nullable();     // 手机号
            $table->text('more')->nullable();                                       // 扩展字段
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
