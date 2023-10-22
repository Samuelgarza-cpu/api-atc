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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email'); //->unique();
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles', 'id');
            $table->string('phone')->default('No Aplica');
            $table->string('name')->nullable()->default('No Aplica');
            $table->string('paternal_last_name')->nullable()->default('No Aplica');
            $table->string('maternal_last_name')->nullable()->default('No Aplica');
            $table->string('curp')->nullable();
            $table->string('sexo')->nullable();
            $table->boolean('active')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
