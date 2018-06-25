<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTblPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table) {
            $table->increments('id', false, true);
            $table->string('titulo');
            $table->text('corpo');
            $table->tinyInteger('utilizador_id', false, false);
            $table->foreign('utilizador_id')->references('id')->on('utilizadores');
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
