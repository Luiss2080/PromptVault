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
        Schema::table('compartidos', function (Blueprint $table) {
            $table->uuid('token')->after('id')->unique()->nullable();
            $table->enum('tipo_acceso', ['solo_lectura', 'puede_copiar', 'puede_editar'])->after('token')->default('solo_lectura');
            $table->timestamp('fecha_expiracion')->after('tipo_acceso')->nullable();
            $table->boolean('requiere_autenticacion')->after('fecha_expiracion')->default(false);
            $table->integer('veces_accedido')->after('requiere_autenticacion')->default(0);
            $table->timestamp('ultimo_acceso')->after('veces_accedido')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compartidos', function (Blueprint $table) {
            //
        });
    }
};
