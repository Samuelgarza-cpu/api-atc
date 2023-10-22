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
        Schema::create('departamentos_asuntos', function (Blueprint $table) {
        
            $table->foreignId('department_id')->constrained('departments','id');
            $table->foreignId('asunto_id')->constrained('asuntos','id');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos_asuntos');
    }
};
