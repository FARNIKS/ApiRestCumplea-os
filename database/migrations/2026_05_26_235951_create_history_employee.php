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
        Schema::create('history_employees', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 50);
            $table->string('nombre');
            $table->string('centro_costo')->nullable();
            $table->string('puesto')->nullable();
            $table->string('empresa_code', 10);
            $table->date('fecha_ingreso')->nullable();
            $table->timestamp('fecha_envio')->useCurrent();
            $table->timestamps();

            $table->index(['cedula', 'fecha_ingreso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_employees');
    }
};
