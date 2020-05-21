<?php
    include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EasyJobs</title>
        <?php
            include_once '../Base/header.php';
            include_once '../Controle/EnderecoPDO.php';
            include_once '../Modelo/Endereco.php';
            $enderecoPDO = new enderecoPDO();
        ?>
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Endereco</h4>
                    <tr class="center">

                        <td class='center'>Id_endereco</td>
                        <td class='center'>Endereco</td>
                        <td class='center'>Cep</td>
                        <td class='center'>Numero</td>
                        <td class='center'>Complemento</td>
                        <td class='center'>Estado</td>
                        <td class='center'>Cidade</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $enderecoPDO->selectEndereco();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $endereco = new endereco($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $endereco->getId_endereco()?></td>
                            <td class="center"><?php echo $endereco->getEndereco()?></td>
                            <td class="center"><?php echo $endereco->getCep()?></td>
                            <td class="center"><?php echo $endereco->getNumero()?></td>
                            <td class="center"><?php echo $endereco->getComplemento()?></td>
                            <td class="center"><?php echo $endereco->getEstado()?></td>
                            <td class="center"><?php echo $endereco->getCidade()?></td>
                            <td class = 'center'><a href="./editarEndereco.php?id=<?php echo $endereco->getid_endereco()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/EnderecoControle.php?function=deletar&id=<?php echo $endereco->getid_endereco()?>">Excluir</a></td>
                        </tr>
                                <?php
                        }
                    }
                    ?>
                    </table>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

