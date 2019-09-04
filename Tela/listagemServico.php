<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem Servico</title>
        <?php
            include_once '../Base/header.php';
            include_once '../Controle/servicoPDO.php';
            include_once '../Modelo/Servico.php';
            $servicoPDO = new servicoPDO();
        ?>
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Servico</h4>
                    <tr class="center">

                        <td class='center'>Id_usuario</td>
                        <td class='center'>Nome</td>
                        <td class='center'>Descricao</td>
                        <td class='center'>Salario</td>
                        <td class='center'>Id_endereco</td>
                        <td class='center'>Id_empregado</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $servicoPDO->selectServico();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $servico = new servico($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $servico->getId_usuario()?></td>
                            <td class="center"><?php echo $servico->getNome()?></td>
                            <td class="center"><?php echo $servico->getDescricao()?></td>
                            <td class="center"><?php echo $servico->getSalario()?></td>
                            <td class="center"><?php echo $servico->getId_endereco()?></td>
                            <td class="center"><?php echo $servico->getId_empregado()?></td>
                            <td class = 'center'><a href="./editarServico.php?id=<?php echo $servico->getid_usuario()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/servicoControle.php?function=deletar&id=<?php echo $servico->getid_usuario()?>">Excluir</a></td>
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

