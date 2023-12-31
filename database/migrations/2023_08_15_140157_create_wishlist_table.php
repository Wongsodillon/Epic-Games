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
        Schema::create('wishlist', function (Blueprint $table) {
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("game_id");
            $table->primary(["user_id", "game_id"]);
            $table->foreign("user_id")->references("user_id")->on("users");
            $table->foreign("game_id")->references("game_id")->on("games");
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
        Schema::dropIfExists('wishlist');
    }
};
