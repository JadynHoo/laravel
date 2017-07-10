<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('conf_id');
            $table->string('conf_title')->default('')->comment('//名称');
            $table->string('conf_name')->default('')->comment('//名称');
            $table->text('conf_content')->default('')->comment('//导航了下面的英文');
            $table->string('conf_tips')->default('')->comment('//链接');
            $table->integer('conf_order')->default(0)->comment('//排序');
            $table->string('field_type')->default('')->comment('//排序');
            $table->string('field_value')->default('')->comment('//排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configs');
    }
}
