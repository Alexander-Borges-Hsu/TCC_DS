@extends('layouts.mainForms')
@section('content')

<div class="container_editar">
  <h2>VerdeChat</h2>

  <form id="iaForm">
    @csrf
    <label for="userPrompt">Faça qualquer pergunta sobre o tema ambiental</label>
    <textarea id="userPrompt" rows="4" required placeholder="Digite aqui sua dúvida sobre meio ambiente..."></textarea>

    <button type="submit" class="btn-save">Enviar para IA</button>
  </form>

  <div id="iaResponseContainer" style="display: none; margin-top: 20px;">
    <h3>Resposta da IA:</h3>
    <div id="iaResponse" class="ia-response-box"></div>
  </div>

  <div id="iaError" class="error" style="display: none; margin-top: 15px;"></div>
</div>

<script>
  document.getElementById('iaForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const promptInput = document.getElementById('userPrompt');
  const prompt = promptInput.value.trim();

  const responseContainer = document.getElementById('iaResponseContainer');
  const responseBox = document.getElementById('iaResponse');
  const errorBox = document.getElementById('iaError');

  responseBox.innerHTML = "Aguarde... a IA está respondendo.";
  responseContainer.style.display = "block";
  errorBox.style.display = "none";

  promptInput.value = "";

  try {
    const res = await fetch("{{ route('ia.perguntar') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({ question: prompt })
    });

    const data = await res.json();

    if (res.ok && data.answer) {
      responseBox.innerHTML = data.answer;
    } else {
      throw new Error(data.error || "Erro desconhecido ao consultar IA.");
    }
  } catch (err) {
    responseContainer.style.display = "none";
    errorBox.textContent = err.message;
    errorBox.style.display = "block";
  }
});

</script>

@endsection
