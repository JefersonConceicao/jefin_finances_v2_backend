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
            $table->increments('id');
            $table->string('email', 50)->default('0');
            $table->char('name', 50)->default('0');
            $table->char('last_name', 50)->default('0');
            $table->string('mail_token_confirm')->nullable();
            $table->string('password_token_reset')->nullable();
            $table->string('password')->default('0');
            $table->timestamps();
            $table->integer('ativo')->default(1);
            $table->integer('temp_user')->default(0);
            $table->dateTime('last_login')->nullable();
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
