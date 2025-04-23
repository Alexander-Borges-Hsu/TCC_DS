<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerdeCalc</title>
    <link rel="icon" href="/imagens/imagem.png">
    <link rel="stylesheet" href="/css/editarPerfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">Configurações do perfil</h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Geral</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Alterar senha</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="/imagens/perfil.jpg" alt class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">Enviar nova foto
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;
                                    <button type="button" class="btn btn-default md-btn-flat">Redefinir</button>
                                    <div class="text-light small mt-1">Permitido JPG, GIF ou PNG. Tamanho máximo de 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" value="Nome_Usuário">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Empresa</label>
                                    <input type="text" class="form-control" value="Empresa_Usuário">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Senha atual</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nova senha</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repetir nova senha</label>
                                    <input type="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        
        <div class="text-right mt-3">
            <button type="button" class="btn btn-primary">Salvar alterações</button>&nbsp;
            <button type="button" class="btn btn-default">Cancelar</button>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    </script>
    
</body>
</html>
