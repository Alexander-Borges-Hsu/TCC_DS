@extends('layouts.mainForms')
@section('content')

<div class="container_editar">
  <h2>Editar Perfil</h2>
  <form id="profileForm">
    <label for="profilePic">Foto de Perfil:</label>
    <input type="file" id="profilePic" accept="image/*">

    <div class="avatar-container">
      <img id="preview" src="" alt="Prévia da imagem">
    </div>

    <label for="userName">Nome do Usuário:</label>
    <input type="text" id="userName" required>

    <label for="companyName">Nome da Empresa:</label>
    <input type="text" id="companyName" required>

    <div class="section">
      <h3>Alterar Senha</h3>

      <label for="currentPassword">Senha Atual:</label>
      <input type="password" id="currentPassword" required>

      <label for="newPassword">Nova Senha:</label>
      <input type="password" id="newPassword" required>

      <label for="confirmPassword">Repetir Nova Senha:</label>
      <input type="password" id="confirmPassword" required>

      <div id="passwordError" class="error"></div>
    </div>

    <button type="submit" class="btn-save">Salvar Alterações</button>
  </form>
</div>

<script>
  const senhaAtualCadastrada = "senha123";

  document.getElementById("profileForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const current = document.getElementById("currentPassword").value;
    const nova = document.getElementById("newPassword").value;
    const repetir = document.getElementById("confirmPassword").value;
    const errorDiv = document.getElementById("passwordError");

    errorDiv.textContent = "";

    if (nova.length < 6) {
      errorDiv.textContent = "A nova senha deve ter no mínimo 6 caracteres.";
      return;
    }

    if (nova === current) {
      errorDiv.textContent = "A nova senha não pode ser igual à senha atual.";
      return;
    }

    if (current !== senhaAtualCadastrada) {
      errorDiv.textContent = "A senha atual está incorreta.";
      return;
    }

    if (nova !== repetir) {
      errorDiv.textContent = "As novas senhas não coincidem.";
      return;
    }

    alert("Perfil atualizado com sucesso!");
  });

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
          alert("A imagem deve ser menor para ser usada como foto de perfil.");
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

@endsection