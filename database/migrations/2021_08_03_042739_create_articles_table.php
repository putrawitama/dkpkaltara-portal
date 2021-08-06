<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('thumbnail');
            $table->string('title');
            $table->longText('description');
            $table->string('slug')->unique();
            $table->tinyInteger('publish')->default(0);
            $table->unsignedBigInteger('sub_menu_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('sub_menu_id')->references('id')->on('sub_menus');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
