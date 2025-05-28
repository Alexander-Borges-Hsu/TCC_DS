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
        // Verifica se a tabela 'users' existe antes de tentar modificá-la
            Schema::table("usuarios", function (Blueprint $table) {
                // Adiciona as novas colunas diretamente
                $table->decimal("co2_consumido", 10, 2)->nullable()->default(0.00)->after;
                $table->decimal("co2_meta", 10, 2)->nullable()->default(0.00)->after("co2_consumido");
                $table->timestamp("data_registro_co2")->nullable()->after("co2_meta");
                $table->string("fonte_emissao_co2")->nullable()->after("data_registro_co2");
                $table->text("observacoes_co2")->nullable()->after("fonte_emissao_co2");
            });
        }
    };  