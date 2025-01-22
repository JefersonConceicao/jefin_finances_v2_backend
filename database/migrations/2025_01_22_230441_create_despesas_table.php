<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('nome_despesa', 100);
            $table->unsignedInteger('despesa_tipo_id');
            $table->decimal('valor_total', 6, 2);
            $table->unsignedTinyInteger('ativo')->default(1);
            $table->timestamps();
            $table->boolean('pago')->default(0);
            
            $table->foreign('despesa_tipo_id', 'FK_despesa_tipo')->references('id')->on('despesas_tipos');
            $table->foreign('user_id', 'FK_user_despesa')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('despesas');
    }
}
