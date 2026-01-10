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
        Schema::create('sesiones_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('filtros_activos')->nullable();
            $table->json('busquedas_recientes')->nullable();
            $table->enum('vista_preferida', ['grid', 'lista'])->default('grid');
            $table->json('columnas_visibles')->nullable();
            $table->string('orden_preferido', 50)->default('reciente');
            $table->timestamp('fecha_expiracion')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones_prompts');
    }
};
