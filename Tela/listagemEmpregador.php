<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem Empregador</title>
        <?php
            include_once '../Base/header.php';
            include_once '../Controle/EmpregadorPDO.php';
            include_once '../Modelo/Empregador.php';
            $empregadorPDO = new empregadorPDO();
        ?>
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Empregador</h4>
                    <tr class="center">

                        <td class='center'>Id_usuario</td>
                        <td class='center'>Razao_social</td>
                        <td class='center'>Cnpj</td>
                        <td class='center'>Nota</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $empregadorPDO->selectEmpregador();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $empregador = new empregador($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $empregador->getId_usuario()?></td>
                            <td class="center"><?php echo $empregador->getRazao_social()?></td>
                            <td class="center"><?php echo $empregador->getCnpj()?></td>
                            <td class="center"><?php echo $empregador->getNota()?></td>
                            <td class = 'center'><a href="./editarEmpregador.php?id=<?php echo $empregador->getid_usuario()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/EmpregadorControle.php?function=deletar&id=<?php echo $empregador->getid_usuario()?>">Excluir</a></td>
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

