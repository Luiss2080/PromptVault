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
        Schema::create('compartidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->constrained()->onDelete('cascade');
            $table->uuid('token')->unique()->nullable();
            $table->enum('tipo_acceso', ['solo_lectura', 'puede_copiar', 'puede_editar'])->default('solo_lectura');
            $table->timestamp('fecha_expiracion')->nullable();
            $table->boolean('requiere_autenticacion')->default(false);
            $table->string('nombre_destinatario', 100)->nullable();
            $table->string('email_destinatario', 100)->nullable();
            $table->text('notas')->nullable();
            $table->integer('veces_accedido')->default(0);
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamp('fecha_compartido')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compartidos');
    }
};
