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
        if (Schema::hasTable("users")) {
            Schema::table("users", function (Blueprint $table) {
                // Define a coluna após a qual as novas serão adicionadas
                $afterColumn = Schema::hasColumn("users", "remember_token") ? "remember_token" : "updated_at";

                // Adiciona as novas colunas diretamente
                $table->decimal("co2_consumido", 10, 2)->nullable()->default(0.00)->after($afterColumn);
                $table->decimal("co2_meta", 10, 2)->nullable()->default(0.00)->after("co2_consumido");
                $table->timestamp("data_registro_co2")->nullable()->after("co2_meta");
                $table->string("fonte_emissao_co2")->nullable()->after("data_registro_co2");
                $table->text("observacoes_co2")->nullable()->after("fonte_emissao_co2");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Verifica se a tabela 'users' existe antes de tentar modificá-la
        if (Schema::hasTable("users")) {
            Schema::table("users", function (Blueprint $table) {
                // Remove as colunas se elas existirem
                $columnsToDrop = [
                    'observacoes_co2',
                    'fonte_emissao_co2',
                    'data_registro_co2',
                    'co2_meta',
                    'co2_consumido'
                ];
                foreach ($columnsToDrop as $column) {
                    if (Schema::hasColumn("users", $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
