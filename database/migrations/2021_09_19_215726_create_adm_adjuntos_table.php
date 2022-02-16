<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_adjuntos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idtipoadjunto')->unsigned();
            $table->integer('IDPROYECTO')->unsigned();
            $table->string('descripcion',100)->nullable();
            $table->timestamps();

            $table->foreign('idtipoadjunto')->references('id')->on('adm_tipoadjuntos');
            $table->foreign('IDPROYECTO')->references('ID_PROYECTO')->on('cc_proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_adjuntos');
    }
}
