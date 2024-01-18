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
        Schema::create('sp_requests', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_solicitud')->nullable();
            $table->string('folio')->nullable();
            $table->string('nombre')->nullable();
            $table->string('app')->nullable();
            $table->string('apm')->nullable();
            $table->string('telefono')->nullable();
            $table->string('cp')->nullable();
            $table->string('calle')->nullable();
            $table->string('num_ext')->nullable();
            $table->string('num_int')->nullable();
            $table->string('colonia')->nullable();
            $table->string('localidad')->nullable()->default('Gómez Palacio');
            $table->string('estado')->nullable()->default('Durango');
            $table->integer('id_departamento_destino')->nullable();
            $table->integer('id_asunto')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('id_estatus')->constrained('estatus', 'id')->default(1);   // ASIGANDO, EN CURSO, ATENDIDO ETC
            $table->boolean('visto')->default(false);
            $table->dateTime('visto_at')->nullable();
            $table->foreignId('id_user_create')->constrained('users', 'id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_requests');
    }
};
