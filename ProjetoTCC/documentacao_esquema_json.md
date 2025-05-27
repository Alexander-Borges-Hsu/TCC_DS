# Documentação do Esquema de Dados via JSON - VerdeCalc

Este documento explica detalhadamente como funciona o sistema de armazenamento e processamento de dados via JSON no sistema VerdeCalc, incluindo os cálculos realizados e o fluxo de informações entre a calculadora e o gerador de relatórios.

## Índice

1. [Visão Geral do Sistema](#visão-geral-do-sistema)
2. [Estrutura do JSON](#estrutura-do-json)
3. [Fluxo de Dados](#fluxo-de-dados)
4. [Cálculos Realizados](#cálculos-realizados)
5. [Processamento para o Relatório](#processamento-para-o-relatório)
6. [Exemplos Práticos](#exemplos-práticos)
7. [Dicas de Manutenção e Extensão](#dicas-de-manutenção-e-extensão)

## Visão Geral do Sistema

O VerdeCalc utiliza um sistema de armazenamento baseado em JSON para persistir os dados de cálculo de emissão de CO₂ dos usuários. Esta abordagem foi escolhida por sua simplicidade, flexibilidade e facilidade de implementação, sem necessidade de criar tabelas adicionais no banco de dados.

O sistema funciona em duas etapas principais:
1. **Calculadora**: Coleta dados de entrada, realiza cálculos e salva os resultados em formato JSON
2. **Relatório**: Lê os dados JSON, processa métricas adicionais e exibe visualizações

## Estrutura do JSON

Os dados são armazenados em arquivos JSON individuais por usuário, localizados em `storage/app/co2_data/user_{id}_co2_data.json`. A estrutura do JSON é a seguinte:

```json
{
  "user_id": 1,
  "co2_consumido": 41.26,
  "co2_meta": 33.01,
  "data_registro_co2": "2025-05-25 16:30:45",
  "fonte_emissao_co2": "Transporte",
  "observacoes_co2": "Cálculo (25/05/2025 16:30): Transporte=34.65kg (150.0km, 7.0L/100km, gasolina); Energia=4.50kg (50.0kWh); Produção=2.11kg (10 unidades).",
  "updated_at": "2025-05-25 16:30:45"
}
```

### Campos Principais

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `user_id` | Integer | ID do usuário no sistema |
| `co2_consumido` | Float | Total de CO₂ emitido em kg (soma de todas as fontes) |
| `co2_meta` | Float | Meta de CO₂ para o usuário (80% do consumo atual) |
| `data_registro_co2` | String | Data e hora do cálculo (formato Y-m-d H:i:s) |
| `fonte_emissao_co2` | String | Principal fonte de emissão (Transporte, Energia Elétrica ou Produção) |
| `observacoes_co2` | String | Texto detalhado com todos os parâmetros do cálculo |
| `updated_at` | String | Data e hora da última atualização |

### Dados Embutidos em `observacoes_co2`

O campo `observacoes_co2` contém uma string formatada com todos os detalhes do cálculo. Esta abordagem permite armazenar dados detalhados sem aumentar a complexidade da estrutura JSON. Os valores são extraídos posteriormente pelo `RelatorioController` quando necessário.

Formato: `"Cálculo (DATA): Transporte=Xkg (Ykm, ZL/100km, COMBUSTÍVEL); Energia=Akg (BkWh); Produção=Ckg (D unidades)."`

## Fluxo de Dados

### 1. Entrada de Dados na Calculadora

O usuário preenche o formulário da calculadora com:
- Distância percorrida (km)
- Consumo de combustível (L/100km)
- Tipo de combustível (gasolina, diesel, etanol)
- Consumo de energia elétrica (kWh)
- Unidades produzidas/serviços

### 2. Processamento no `CalculadoraController`

1. **Validação dos dados** - Verifica se os campos obrigatórios estão preenchidos e se os valores são válidos
2. **Cálculo das emissões** - Aplica fatores de emissão para cada fonte
3. **Determinação da meta** - Define a meta como 80% do consumo atual
4. **Identificação da fonte principal** - Determina qual fonte tem maior contribuição
5. **Formatação dos dados** - Prepara o objeto JSON com todos os campos necessários
6. **Armazenamento** - Salva os dados em um arquivo JSON específico para o usuário

### 3. Leitura no `RelatorioController`

1. **Recuperação do arquivo** - Localiza e lê o arquivo JSON do usuário
2. **Decodificação** - Converte o JSON em um array associativo PHP
3. **Extração de dados** - Obtém os valores principais e processa dados adicionais
4. **Cálculo de métricas avançadas** - Calcula intensidade de carbono, pontuação, etc.
5. **Preparação para visualização** - Formata os dados para exibição no relatório

### 4. Exibição no `geradorRelatorios.blade.php`

1. **Renderização dos dados** - Exibe os valores em cartões e gráficos
2. **Inicialização de gráficos** - Passa os dados para o JavaScript via objeto `window.dadosGrafico`
3. **Visualização interativa** - Mostra o gauge e outras visualizações

## Cálculos Realizados

### Cálculos Básicos (CalculadoraController)

#### 1. Emissão por Transporte
```php
$consumo_total_combustivel = ($distancia / 100) * $consumo_combustivel;
$emissao_transporte = $consumo_total_combustivel * $fatores[$tipo_combustivel];
```

Exemplo: 150km com consumo de 7L/100km usando gasolina
- Consumo total: (150 / 100) * 7 = 10.5L
- Emissão: 10.5 * 2.31 = 24.255kg de CO₂

#### 2. Emissão por Energia Elétrica
```php
$emissao_energia = $consumo_energia * $fatores["energia"];
```

Exemplo: 50kWh de energia
- Emissão: 50 * 0.09 = 4.5kg de CO₂

#### 3. Emissão por Produção
```php
$emissao_producao = $producao * $fatores["producao"];
```

Exemplo: 10 unidades produzidas
- Emissão: 10 * 0.5 = 5kg de CO₂

#### 4. Emissão Total e Meta
```php
$co2_consumido = $emissao_transporte + $emissao_energia + $emissao_producao;
$co2_meta = $co2_consumido * 0.8;
```

Exemplo: Com os valores acima
- Total: 24.255 + 4.5 + 5 = 33.755kg de CO₂
- Meta: 33.755 * 0.8 = 27.004kg de CO₂

### Cálculos Avançados (RelatorioController)

#### 1. Percentual da Meta
```php
$percentual_meta = ($co2_consumido / $co2_meta) * 100;
```

Exemplo: Com os valores acima
- Percentual: (33.755 / 27.004) * 100 = 125%

#### 2. Intensidade de Carbono
```php
$intensidade_carbono = $co2_consumido / $unidades_produzidas;
```

Exemplo: 33.755kg de CO₂ para 10 unidades
- Intensidade: 33.755 / 10 = 3.3755kg de CO₂ por unidade

#### 3. Pontuação de Sustentabilidade
```php
$pontuacao_base = $percentual_meta <= 100 ? (100 - $percentual_meta) : 0;
$pontuacao_ajustada = max(0, min(100, $pontuacao_base));
```

Exemplo: Com percentual de 125%
- Pontuação base: 0 (acima da meta)
- Pontuação ajustada: 0

#### 4. Impacto Ambiental Equivalente
```php
$arvores_necessarias = ceil($co2_consumido / 22);
$km_carro = ceil($co2_consumido * 6);
$meses_energia_casa = ceil($co2_consumido / 100);
```

Exemplo: 33.755kg de CO₂
- Árvores: ceil(33.755 / 22) = 2 árvores
- Km de carro: ceil(33.755 * 6) = 203km
- Meses de energia: ceil(33.755 / 100) = 1 mês

## Processamento para o Relatório

### 1. Extração de Dados do JSON

O `RelatorioController` decodifica o JSON e extrai os valores principais:

```php
$co2Data = json_decode($user->co2_data, true);
$co2_consumido = $co2Data['co2_total'] ?? 0;
$co2_meta = $co2Data['co2_meta'] ?? 0;
```

### 2. Extração de Dados das Observações

Alguns dados detalhados são extraídos do campo `observacoes_co2` usando expressões regulares:

```php
// Exemplo de como extrair valores das observações
preg_match('/Transporte=([\d\.]+)kg/', $co2Data['observacoes_co2'], $matches);
$emissao_transporte = $matches[1] ?? 0;
```

### 3. Determinação do Status

O status é determinado com base no percentual da meta:

```php
if ($percentual_meta <= 80) {
    // Excelente
} elseif ($percentual_meta <= 100) {
    // Bom
} elseif ($percentual_meta <= 120) {
    // Regular
} else {
    // Ruim
}
```

### 4. Preparação para Visualização

Os dados são formatados para exibição e passados para a view:

```php
return view('geradorRelatorios', compact(
    'co2_consumido',
    'co2_meta',
    'percentual_meta',
    // ... outros dados
));
```

### 5. Inicialização de Gráficos via JavaScript

Os dados são passados para o JavaScript através de um objeto global:

```javascript
window.dadosGrafico = {
    percentualMeta: {{ $percentual_meta ?? 0 }},
    statusCor: "{{ $status_co2['cor'] ?? '#ef4444' }}"
};
```

## Exemplos Práticos

### Exemplo 1: Cálculo Completo

**Dados de entrada:**
- Distância: 150km
- Consumo: 7L/100km
- Combustível: Gasolina
- Energia: 50kWh
- Produção: 10 unidades

**JSON gerado:**
```json
{
  "user_id": 1,
  "co2_consumido": 33.76,
  "co2_meta": 27.00,
  "data_registro_co2": "2025-05-25 16:30:45",
  "fonte_emissao_co2": "Transporte",
  "observacoes_co2": "Cálculo (25/05/2025 16:30): Transporte=24.26kg (150.0km, 7.0L/100km, gasolina); Energia=4.50kg (50.0kWh); Produção=5.00kg (10 unidades).",
  "updated_at": "2025-05-25 16:30:45"
}
```

**Dados processados para o relatório:**
- CO₂ Consumido: 33,76 kg
- Meta de CO₂: 27,00 kg
- Percentual da Meta: 125%
- Status: Ruim
- Intensidade de Carbono: 3,38 kg CO₂/unidade
- Pontuação de Sustentabilidade: 0/100
- Árvores Necessárias: 2
- Km de Carro Equivalentes: 203
- Meses de Energia Residencial: 1

### Exemplo 2: Cálculo Abaixo da Meta

**Dados de entrada:**
- Distância: 80km
- Consumo: 5L/100km
- Combustível: Etanol
- Energia: 30kWh
- Produção: 5 unidades

**JSON gerado:**
```json
{
  "user_id": 1,
  "co2_consumido": 7.42,
  "co2_meta": 5.94,
  "data_registro_co2": "2025-05-25 17:15:30",
  "fonte_emissao_co2": "Transporte",
  "observacoes_co2": "Cálculo (25/05/2025 17:15): Transporte=4.72kg (80.0km, 5.0L/100km, etanol); Energia=2.70kg (30.0kWh); Produção=2.50kg (5 unidades).",
  "updated_at": "2025-05-25 17:15:30"
}
```

**Dados processados para o relatório:**
- CO₂ Consumido: 7,42 kg
- Meta de CO₂: 5,94 kg
- Percentual da Meta: 125%
- Status: Ruim
- Intensidade de Carbono: 1,48 kg CO₂/unidade
- Pontuação de Sustentabilidade: 0/100
- Árvores Necessárias: 1
- Km de Carro Equivalentes: 45
- Meses de Energia Residencial: 1

## Dicas de Manutenção e Extensão

### Adicionando Novos Campos ao JSON

Para adicionar novos campos ao JSON:

1. Modifique o array `$co2Data` no `CalculadoraController`:
   ```php
   $co2Data = [
       // Campos existentes
       "novo_campo" => $valor_calculado,
   ];
   ```

2. Atualize o `RelatorioController` para ler o novo campo:
   ```php
   $novo_campo = $co2Data['novo_campo'] ?? $valor_padrao;
   ```

3. Passe o novo campo para a view:
   ```php
   return view('geradorRelatorios', compact('novo_campo', /* outros campos */));
   ```

### Modificando os Cálculos

Para alterar os cálculos:

1. Atualize os fatores de emissão no `CalculadoraController`:
   ```php
   $fatores = [
       "gasolina" => 2.31, // Altere este valor conforme necessário
       // Outros fatores
   ];
   ```

2. Modifique as fórmulas de cálculo conforme necessário:
   ```php
   $emissao_transporte = $consumo_total_combustivel * $fatores[$request->input("tipo_combustivel")] * $novo_fator;
   ```

### Implementando Histórico Real

Para implementar um histórico real de cálculos:

1. Modifique o `CalculadoraController` para salvar cada cálculo em um array de histórico:
   ```php
   // Ler histórico existente
   $jsonFilePath = storage_path('app/co2_data/user_' . $usuario->id . '_co2_data.json');
   $historico = [];
   if (file_exists($jsonFilePath)) {
       $dadosExistentes = json_decode(file_get_contents($jsonFilePath), true);
       $historico = $dadosExistentes['historico'] ?? [];
   }
   
   // Adicionar novo cálculo ao histórico
   $historico[] = [
       "data" => Carbon::now()->format('Y-m-d H:i:s'),
       "co2_consumido" => round($co2_consumido, 2),
       "co2_meta" => round($co2_meta, 2),
       // Outros campos
   ];
   
   // Salvar tudo
   $co2Data = [
       // Campos existentes
       "historico" => $historico
   ];
   ```

2. Atualize o `RelatorioController` para processar o histórico:
   ```php
   $historico = $co2Data['historico'] ?? [];
   
   // Preparar dados para gráfico de histórico
   $labels = [];
   $valores = [];
   foreach ($historico as $registro) {
       $labels[] = Carbon::parse($registro['data'])->format('d/m');
       $valores[] = $registro['co2_consumido'];
   }
   
   $dadosGrafico = [
       'labels' => $labels,
       'valores' => $valores
   ];
   ```

3. Atualize o JavaScript para exibir o gráfico de histórico.

### Melhorando a Segurança

Para melhorar a segurança dos dados:

1. Considere criptografar o conteúdo do JSON:
   ```php
   $jsonEncriptado = encrypt(json_encode($co2Data));
   file_put_contents($jsonFilePath, $jsonEncriptado);
   ```

2. Na leitura, descriptografe:
   ```php
   $jsonEncriptado = file_get_contents($jsonFilePath);
   $co2Data = json_decode(decrypt($jsonEncriptado), true);
   ```

3. Implemente verificações de permissão para garantir que usuários só acessem seus próprios dados.
