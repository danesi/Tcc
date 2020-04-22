<!doctype html>
<html lang="br">
<head>
    <meta charset="UTF-8">
</head>
<style>
    div, h4, p {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
<body>
<div>
    <h4>Novo serviço cadastrado</h4>
    <p>O usuário '.$usuario->getNome().' solicitou o cadastro de um novo serviço, por favor acesse o link a baixo para
        avaliar essa solicitação</p>
    <a href="localhost/tcc/tela/solicitacoes.php?nome='.$nome_servico.'">Clique aqui para avaliar essa solicitação</a>
</div>
</body>
</html>

