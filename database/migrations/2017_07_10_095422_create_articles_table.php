<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('art_id');
            $table->string('art_title')->default('')->comment('//标题');
            $table->string('art_tag')->default('')->comment('//关键字');
            $table->string('art_description')->default('')->comment('//描述');
            $table->string('art_thumb')->default('')->comment('//图片地址');
            $table->text('art_content')->default('')->comment('//文章内容');
            $table->integer('art_time')->default('')->comment('//时间');
            $table->string('art_editor')->default('')->comment('//作者');
            $table->integer('art_view')->default('')->comment('//查看次数');
            $table->integer('cate_id')->default('')->comment('//分类id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
