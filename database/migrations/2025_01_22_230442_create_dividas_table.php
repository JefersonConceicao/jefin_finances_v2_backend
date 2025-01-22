<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDividasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dividas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao_divida')->default('0');
            $table->integer('qtd_parcela_total')->default(0);
            $table->integer('qtd_parcela_parcial')->default(0);
            $table->float('valor_total', 11, 2)->default(0.00);
            $table->float('valor_parcial', 6, 2)->default(0.00);
            $table->float('valor_parcela', 6, 2)->default(0.00);
            $table->timestamps();
            $table->date('data_fim_divida')->nullable();
            $table->date('data_inicial_divida')->nullable();
            $table->integer('pago')->default(0);
            $table->unsignedInteger('user_id')->nullable();
            
            $table->foreign('user_id', 'FK_divida_user')->references('id')->on('users')->onDelete('set NULL')->onUpdate('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dividas');
    }
}
