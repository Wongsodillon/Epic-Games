<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments("game_id");
            $table->string("name");
            $table->unsignedInteger("genre_id");
            $table->foreign("genre_id")->references("genre_id")->on("genre");
            $table->integer("price");
            $table->integer("discount_percent");
            $table->string("description", 1000);
            $table->string("company");
            $table->string("url");
            $table->string("logo");
            $table->string("banner");
            $table->string("release_date");
            $table->string("os");
            $table->string("gpu");
            $table->string("cpu");
            $table->string('ram');
            $table->string("storage");
            $table->string("directx");
            $table->integer("downloads");
            $table->float("rating");
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
        Schema::dropIfExists('games');
    }
};
