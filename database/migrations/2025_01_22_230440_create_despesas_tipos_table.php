<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 120)->default('0');
            $table->integer('ativo')->default(1);
            $table->unsignedInteger('user_id')->nullable();
            
            $table->foreign('user_id', 'FK_despesas_tipos_users')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('despesas_tipos');
    }
}
