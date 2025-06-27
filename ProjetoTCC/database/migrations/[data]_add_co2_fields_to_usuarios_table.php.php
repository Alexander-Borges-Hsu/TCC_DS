<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->decimal('co2_consumido', 10, 2)->nullable();
            $table->decimal('co2_meta', 10, 2)->nullable();
            $table->date('data_registro_co2')->nullable();
            $table->string('fonte_emissao_co2')->nullable();
            $table->text('observacoes_co2')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'co2_consumido',
                'co2_meta',
                'data_registro_co2',
                'fonte_emissao_co2',
                'observacoes_co2'
            ]);
        });
    }
};