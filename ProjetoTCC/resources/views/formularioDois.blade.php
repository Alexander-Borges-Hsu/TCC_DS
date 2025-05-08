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
  <h1 class="titulo3">NOTÍCIAS E ACONTECIMENTOS ATUAIS.</h1>
  <div class="container">
    <div class="card">
      <div class="categoria-noticias">
        <a href="https://www.cnnbrasil.com.br/internacional/aquecimento-global-tornara-cidades-quentes-demais-para-olimpiadas-ate-2050/"
          target="_blank">
          <img src="/imagens/mudancas-climaticas.webp" alt="Notícia" class="noticia-img">
        </a>
      </div>
      <a href="https://www.cnnbrasil.com.br/internacional/aquecimento-global-tornara-cidades-quentes-demais-para-olimpiadas-ate-2050/"
        target="_blank">
        <h2 class="titulo2">Aquecimento global tornará cidades quentes demais para Olimpíadas até 2050</h2>
      </a>
      <a href="https://www.cnnbrasil.com.br/internacional/aquecimento-global-tornara-cidades-quentes-demais-para-olimpiadas-ate-2050/"
        target="_blank">
        <h5>Pesquisa mostrou que estresse por calor excederá limites permitidos, podendo causar o cancelamento de
          eventos esportivos</h5>
      </a>
      <a href="https://www.cnnbrasil.com.br/" target="_blank">
        <p class="fonte">Fonte: cnnbrasil</p>
      </a>
    </div>

    <div class="card">
      <div class="categoria-noticias">
        <a href="https://www.cnnbrasil.com.br/colunas/geyze-diniz/nacional/brasil/o-que-o-aquecimento-global-tem-a-ver-com-o-seu-prato-de-comida/"
          target="_blank">
          <img src="/imagens/aquecimento-global.webp" alt="Notícia" class="noticia-img">
        </a>
      </div>
      <a href="https://www.cnnbrasil.com.br/colunas/geyze-diniz/nacional/brasil/o-que-o-aquecimento-global-tem-a-ver-com-o-seu-prato-de-comida/"
        target="_blank">
        <h2 class="titulo2">O que o aquecimento global tem a ver com seu prato de comida?</h2>
      </a>
      <a href="https://www.cnnbrasil.com.br/colunas/geyze-diniz/nacional/brasil/o-que-o-aquecimento-global-tem-a-ver-com-o-seu-prato-de-comida/"
        target="_blank">
        <h5>A crise climática já nos afeta e agrava a desigualdade – agir agora é urgente.</h5>
      </a>
      <a href="https://www.cnnbrasil.com.br/" target="_blank">
        <p class="fonte">Fonte: cnnbrasil</p>
      </a>
    </div>

    <div class="card">
      <div class="categoria-noticias">
        <a href="https://www.cnnbrasil.com.br/tecnologia/o-que-foi-decidido-em-cada-cop-veja-linha-do-tempo/"
          target="_blank">
          <img src="/imagens/cop.webp" alt="Notícia" class="noticia-img">
        </a>
      </div>
      <a href="https://www.cnnbrasil.com.br/tecnologia/o-que-foi-decidido-em-cada-cop-veja-linha-do-tempo/"
        target="_blank">
        <h2 class="titulo2">O que foi decidido em cada COP? Veja linha do tempo</h2>
      </a>
      <a href="https://www.cnnbrasil.com.br/tecnologia/o-que-foi-decidido-em-cada-cop-veja-linha-do-tempo/"
        target="_blank">
        <h5>30ª cúpula do clima acontece no Brasil em novembro deste ano</h5>
      </a>
      <a href="https://www.cnnbrasil.com.br/" target="_blank">
        <p class="fonte">Fonte: cnnbrasil</p>
      </a>
    </div>
  </div>
<script src="/js/script.js"></script>
@endsection