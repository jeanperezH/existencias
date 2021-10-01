<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_producto')->unsigned();
            $table->boolean('tipo');
            $table->date('fecha');
            $table->integer('cantidad');
            $table->float('costo_unitario');
            $table->float('costo_total');
            $table->foreign('id_producto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_outs');
    }
}
