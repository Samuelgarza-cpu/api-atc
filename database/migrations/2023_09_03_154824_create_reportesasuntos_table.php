<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_asuntos', function (Blueprint $table) {
           
            $table->foreignId('id_reporte')->constrained('reportes','id');
            $table->foreignId('id_servicio')->constrained('servicios','id')->default(1); //  QUEJA, SOSPECHA, DEMANDA ETC
            $table->foreignId('id_asunto')->constrained('asuntos','id');
            $table->string('observaciones');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes_asuntos');
    }
};
