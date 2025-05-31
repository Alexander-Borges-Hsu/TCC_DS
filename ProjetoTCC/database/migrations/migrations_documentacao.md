# Documentação de Migrations para o Projeto VerdeCalc

Este documento descreve as migrations necessárias para implementar as funcionalidades de formulários, calculadora e relatórios no projeto VerdeCalc.

## Visão Geral

O sistema VerdeCalc utiliza uma abordagem híbrida para armazenamento de dados:

1. **Dados estruturados**: Armazenados em tabelas relacionais específicas
2. **Dados flexíveis**: Armazenados em formato JSON no campo `co2_data` da tabela `users`

Esta abordagem permite flexibilidade para adicionar novos tipos de cálculos e métricas sem alterar constantemente o esquema do banco de dados.

## Migrations Necessárias

### 1. Migration para Formulários

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('form_type'); // Tipo de formulário (Um, Dois, etc.)
            $table->json('form_data'); // Dados do formulário em formato JSON
            $table->boolean('is_complete')->default(false); // Se o formulário está completo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_data');
    }
}
```

**Descrição dos campos:**
- `user_id`: Chave estrangeira para o usuário que preencheu o formulário
- `form_type`: Identifica o tipo de formulário (ex: "formulario_um", "formulario_dois")
- `form_data`: Armazena todos os dados do formulário em formato JSON
- `is_complete`: Indica se o formulário foi completamente preenchido

**Exemplo de dados JSON armazenados:**
```json
{
  "empresa": {
    "cnpj": "12.345.678/0001-90",
    "nome": "Empresa Verde Ltda",
    "endereco": "Av. Paulista, 1000",
    "ramo_atividade": "Tecnologia",
    "num_funcionarios": 50
  },
  "sustentabilidade": {
    "monitoramento_co2": "sim",
    "fontes_emissao": ["Transporte", "Energia"],
    "certificacoes": "sim",
    "acoes_reducao": "sim",
    "calculo_pegada": "nao",
    "matriz_energetica": "Solar"
  },
  "data_registro": "2025-05-27 10:30:00"
}
```

### 2. Migration para Cálculos de Emissão

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('calculation_type'); // Tipo de cálculo (veículo, energia, etc.)
            $table->json('input_data'); // Dados de entrada em formato JSON
            $table->json('result_data'); // Resultados em formato JSON
            $table->decimal('total_emissions', 10, 2); // Total de emissões calculadas
            $table->timestamp('calculation_date'); // Data do cálculo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
```

**Descrição dos campos:**
- `user_id`: Chave estrangeira para o usuário que realizou o cálculo
- `calculation_type`: Tipo de cálculo realizado (ex: "transporte", "energia", "completo")
- `input_data`: Armazena os dados de entrada do cálculo em formato JSON
- `result_data`: Armazena os resultados do cálculo em formato JSON
- `total_emissions`: Valor total de emissões calculadas (para facilitar consultas e ordenação)
- `calculation_date`: Data e hora em que o cálculo foi realizado

**Exemplo de dados JSON de entrada:**
```json
{
  "transporte": {
    "distancia": 100,
    "consumo_combustivel": 10,
    "tipo_combustivel": "gasolina"
  },
  "energia": {
    "consumo_energia": 500
  },
  "producao": {
    "unidades_produzidas": 1000
  }
}
```

**Exemplo de dados JSON de resultado:**
```json
{
  "emissao_transporte": 231.0,
  "emissao_energia": 40.85,
  "emissao_producao": 500.0,
  "emissao_total": 771.85,
  "fonte_principal": "Produção",
  "intensidade_carbono": 0.77
}
```

### 3. Migration para Relatórios

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('calculation_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('report_type'); // Tipo de relatório (emissões, comparativo, etc.)
            $table->json('report_data'); // Dados do relatório em formato JSON
            $table->decimal('co2_total', 10, 2); // Total de CO2 no relatório
            $table->decimal('co2_meta', 10, 2)->nullable(); // Meta de CO2 definida
            $table->timestamp('report_date'); // Data do relatório
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
```

**Descrição dos campos:**
- `user_id`: Chave estrangeira para o usuário que gerou o relatório
- `calculation_id`: Referência opcional ao cálculo que gerou este relatório
- `title`: Título do relatório
- `report_type`: Tipo de relatório (ex: "emissoes", "comparativo", "historico")
- `report_data`: Armazena os dados completos do relatório em formato JSON
- `co2_total`: Valor total de CO2 no relatório (para facilitar consultas e ordenação)
- `co2_meta`: Meta de CO2 definida para comparação
- `report_date`: Data e hora em que o relatório foi gerado

**Exemplo de dados JSON de relatório:**
```json
{
  "status": {
    "texto": "Atenção",
    "cor": "#f59e0b",
    "icone": "fa-exclamation-circle",
    "descricao": "Sua empresa está na linha limite da meta de emissão de CO₂."
  },
  "metricas": {
    "co2_consumido": 771.85,
    "co2_meta": 1000,
    "percentual_meta": 77.19,
    "reducao_necessaria": 0,
    "intensidade_carbono": 0.77,
    "pontuacao": 22.81
  },
  "emissoes": {
    "transporte": 231.0,
    "energia": 40.85,
    "producao": 500.0,
    "fonte_principal": "Produção"
  },
  "impacto_ambiental": {
    "arvores_necessarias": 35,
    "km_carro": 6432,
    "meses_energia_casa": 8
  },
  "dicas_reducao": [
    "Otimize processos produtivos para reduzir desperdícios",
    "Invista em tecnologias mais limpas e eficientes",
    "Implemente sistemas de gestão ambiental (ISO 14001)",
    "Considere a economia circular e reutilização de materiais",
    "Treine funcionários em práticas sustentáveis de produção"
  ]
}
```

### 4. Migration para Metas de CO2

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCo2GoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co2_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('annual_goal', 10, 2); // Meta anual de CO2
            $table->decimal('monthly_goal', 10, 2); // Meta mensal de CO2
            $table->year('goal_year'); // Ano da meta
            $table->text('goal_description')->nullable(); // Descrição da meta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('co2_goals');
    }
}
```

**Descrição dos campos:**
- `user_id`: Chave estrangeira para o usuário dono da meta
- `annual_goal`: Meta anual de emissão de CO2 em kg
- `monthly_goal`: Meta mensal de emissão de CO2 em kg
- `goal_year`: Ano para o qual a meta foi definida
- `goal_description`: Descrição opcional da meta e estratégias para alcançá-la

## Implementação e Uso

Para implementar estas migrations, siga os passos abaixo:

1. Crie os arquivos de migration usando o comando Artisan:
   ```bash
   php artisan make:migration create_form_data_table
   php artisan make:migration create_calculations_table
   php artisan make:migration create_reports_table
   php artisan make:migration create_co2_goals_table
   ```

2. Copie o conteúdo fornecido para cada arquivo de migration correspondente

3. Execute as migrations:
   ```bash
   php artisan migrate
   ```

## Considerações sobre o Modelo Híbrido

O projeto VerdeCalc utiliza um modelo híbrido de armazenamento de dados:

1. **Campo JSON na tabela users**: 
   - Armazena dados temporários e de fluxo entre telas
   - Facilita a implementação rápida de novas funcionalidades
   - Usado principalmente para o fluxo formulário → calculadora → relatório

2. **Tabelas relacionais específicas**:
   - Armazenam dados históricos e permanentes
   - Permitem consultas SQL eficientes para relatórios e análises
   - Facilitam a exportação e backup de dados

Esta abordagem combina a flexibilidade do armazenamento JSON com a robustez e eficiência do modelo relacional tradicional.

## Modelos Eloquent

Para cada tabela, recomenda-se criar um modelo Eloquent correspondente:

```php
// app/Models/FormData.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    protected $fillable = ['user_id', 'form_type', 'form_data', 'is_complete'];
    
    protected $casts = [
        'form_data' => 'array',
        'is_complete' => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

```php
// app/Models/Calculation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = ['user_id', 'calculation_type', 'input_data', 'result_data', 'total_emissions', 'calculation_date'];
    
    protected $casts = [
        'input_data' => 'array',
        'result_data' => 'array',
        'calculation_date' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
```

```php
// app/Models/Report.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'calculation_id', 'title', 'report_type', 'report_data', 'co2_total', 'co2_meta', 'report_date'];
    
    protected $casts = [
        'report_data' => 'array',
        'report_date' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function calculation()
    {
        return $this->belongsTo(Calculation::class);
    }
}
```

```php
// app/Models/Co2Goal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Co2Goal extends Model
{
    protected $fillable = ['user_id', 'annual_goal', 'monthly_goal', 'goal_year', 'goal_description'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## Conclusão

Estas migrations fornecem uma estrutura robusta para armazenar e gerenciar dados relacionados a formulários, cálculos de emissão de CO2 e relatórios no projeto VerdeCalc. A abordagem híbrida (JSON + tabelas relacionais) oferece um bom equilíbrio entre flexibilidade e desempenho.
