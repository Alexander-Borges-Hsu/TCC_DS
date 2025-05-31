<!--
/*
 * Verdecalc
 * Copyright (C) 2025 Equipe Verdecalc
 *
 * Este programa é software livre; você pode redistribuí-lo e/ou
 * modificá-lo sob os termos da Licença Pública Geral GNU conforme
 * publicada pela Free Software Foundation; na versão 2 da licença,
 * ou (a seu critério) qualquer versão posterior.
 *
 * Este programa é distribuído na esperança de que seja útil,
 * mas SEM NENHUMA GARANTIA; sem mesmo a garantia implícita de
 * COMERCIALIZAÇÃO ou ADEQUAÇÃO A UM DETERMINADO FIM. Veja a
 * Licença Pública Geral GNU para mais detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa; se não, veja <https://www.gnu.org/licenses/>.
 */
 !-->

@extends('layouts.mainForms')
@section('content')

    <section class="form-container">
    <h2 class="titulo">Cadastrar novo produto para o cálculo</h2>
    <form method="POST" action="">
        @csrf
        <label>Nome do produto</label>
        <input type="text" name="nome" placeholder="Nome do produto" required>

        <label>Categoria do produto</label>
        <input type="text" name="categoria" placeholder="Ex: Materiais de construção" required>

        <label>Unidade de medida</label>
        <input type="text" name="unidade" placeholder="Ex: kg, litros, unidade" required>

        <label>Fator de emissão (kg CO₂ por unidade)</label>
        <input type="number" step="0.0001" name="fator_emissao" placeholder="Ex: 0.93" required>

        <label>Descrição (opcional)</label>
        <input type="text" name="descricao" placeholder="Detalhes adicionais sobre o produto">

        <br>
        <input type="submit" value="Cadastrar Produto" id="registrar" class="botao-input">
    </form>
</section>

@endsection