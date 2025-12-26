<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni')->nullable()->after('email');
            $table->string('telefono')->nullable()->after('dni');
            $table->string('contacto_emergencia')->nullable()->after('telefono');
            $table->text('informacion_medica')->nullable()->after('contacto_emergencia');
            $table->json('alergias')->default('[]')->after('informacion_medica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dni',
                'telefono',
                'contacto_emergencia',
                'informacion_medica',
                'alergias'
            ]);
        });
    }
};