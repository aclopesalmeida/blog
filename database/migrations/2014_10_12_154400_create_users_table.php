<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilizadores', function (Blueprint $table) {
            $table->tinyInteger('id', true, false);
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role_id', false, false);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
