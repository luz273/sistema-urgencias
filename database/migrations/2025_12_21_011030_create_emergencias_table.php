<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emergencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('users');
            $table->string('tipo_emergencia');
            $table->text('sintomas');
            $table->enum('gravedad', ['leve', 'moderado', 'critico']);
            $table->string('latitud');
            $table->string('longitud');
            $table->string('foto')->nullable();
            $table->enum('estado', ['pendiente', 'en_curso', 'finalizada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencias');
    }
};