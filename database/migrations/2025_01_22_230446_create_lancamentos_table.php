<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('data_lancamento');
            $table->unsignedInteger('despesa_id')->nullable();
            $table->decimal('valor', 6, 2)->nullable();
            $table->string('descricao', 125)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            
            $table->foreign('despesa_id', 'FK_lancamento_despesa')->references('id')->on('despesas');
            $table->foreign('user_id', 'FK_lancamento_users')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamentos');
    }
}
