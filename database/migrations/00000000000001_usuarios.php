<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class usuarios extends Migration
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
            $table->boolean('estado');
            $table->string('rut');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono1');
            $table->string('telefono2');
            $table->string('email')->unique();
            $table->string('contrasenia');
            $table->timestamp('fechacreacion');
            $table->timestamp('fechaactualizacion');

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
}
