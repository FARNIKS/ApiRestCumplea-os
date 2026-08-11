<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('new_employees', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 50)->unique();
            $table->string('nombre');
            $table->string('centro_costo')->nullable();
            $table->string('puesto')->nullable();
            $table->string('empresa_code', 10);
            $table->date('cumple')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->boolean('enviado')->default(false);
            $table->timestamps();

            $table->foreign('empresa_code')->references('code')->on('branches')->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('new_employees');
    }
};
