<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTblPostCategoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_categoria', function(Blueprint $table) {
            $table->integer('post_id', false, true);
            $table->integer('categoria_id', false, false);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
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
        //
    }
}
