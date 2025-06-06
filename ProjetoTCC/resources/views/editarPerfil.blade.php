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

<div class="container_editar">
  <h2>Editar Perfil</h2>
  <form id="profileForm" action="{{ route('editar.perfil') }}" method="POST" enctype="multipart/form-data" >
    @csrf
    @method('PUT')

    <label for="profilePic">Foto de Perfil:</label>
    <input type="file" id="profilePic" accept="image/*" name="profilePic">

    <div class="avatar-container">
      <img id="preview" src="" alt="Prévia da imagem">
    </div>

    <label for="userName">Nome do Usuário:</label>
    <input type="text" id="userName" required value="{{ Auth::user()->nome }}" name="userName">

    <label for="companyName">Nome da Empresa:</label>
    <input type="text" id="companyName" required name="companyName">

    <div class="section">
      <h3>Alterar Senha</h3>

      <label for="currentPassword">Senha Atual:</label>
      <input type="password" id="currentPassword" required name="currentPassword">

      <label for="newPassword">Nova Senha:</label>
      <input type="password" id="newPassword" required name="newPassword">

      <label for="newPassword_confirmation">Repetir Nova Senha:</label>
      <input type="password" id="newPassword_confirmation" required name="newPassword_confirmation">
      <div id="errorDiv" style="color:red">

      </div>
      @if (session('error'))
      <div class="alert alert-danger" id="errorDiv">
      {{session('error') }}
      </div>
      @endif
    </div>
    <a href="/navegar/nova-senha">Esqueci minha senha</a>
    <button type="submit" class="btn-save">Salvar Alterações</button>
  </form>
</div>
@if (session('success'))
  <script>
    alert("{{ session('success') }}");
  </script>
@endif
<script>
  document.getElementById("profileForm").addEventListener("submit", function (event) {
    const errorDiv = document.getElementById("errorDiv");
    errorDiv.textContent = "";

    const nova = document.getElementById("newPassword").value;
    const repetir = document.getElementById("newPassword_confirmation").value;

    if (nova.length > 0 && nova.length < 6) {
      event.preventDefault();
      errorDiv.textContent = "A nova senha deve ter no mínimo 6 caracteres.";
      return;
    }

    if (nova !== repetir) {
      event.preventDefault();
      errorDiv.textContent = "As novas senhas não coincidem.";
      return;
    }

    // Deixe a verificação da senha atual para o back-end.
  });

  // Visualização da imagem de perfil
  const fileInput = document.getElementById("profilePic");
  const previewImg = document.getElementById("preview");

  fileInput.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;

    const validTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"];
    if (!validTypes.includes(file.type)) {
      alert("Apenas arquivos de imagem são permitidos (.jpg, .jpeg, .png, .webp).");
      this.value = "";
      return;
    }

    const maxSizeMB = 2;
    if (file.size > maxSizeMB * 1024 * 1024) {
      alert("A imagem deve ter no máximo 2MB.");
      this.value = "";
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      const img = new Image();
      img.onload = function () {
        if (img.width < 200 || img.height < 200) {
          alert("A imagem deve ter no mínimo 200x200 pixels.");
          fileInput.value = "";
          previewImg.style.display = "none";
          return;
        }

        const aspectRatio = img.width / img.height;
        if (aspectRatio < 0.8 || aspectRatio > 1.25) {
          alert("A imagem deve estar proporcionalmente correta (quase quadrada).");
          fileInput.value = "";
          previewImg.style.display = "none";
          return;
        }

        previewImg.src = e.target.result;
        previewImg.style.display = "block";
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
</script>

@include('layouts.carregamento')
@endsection