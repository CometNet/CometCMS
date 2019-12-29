<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',100);
            $table->string('alias',100);
            $table->text('content')->nullable();
            $table->string('thumbnail',100)->nullable();
            $table->integer('author')->nullable();
            $table->tinyInteger('type')->default(0)->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->text('more')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
