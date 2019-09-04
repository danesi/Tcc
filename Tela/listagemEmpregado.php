<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem Empregado</title>
        <?php
            include_once '../Base/header.php';
            include_once '../Controle/empregadoPDO.php';
            include_once '../Modelo/Empregado.php';
            $empregadoPDO = new empregadoPDO();
        ?>
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Empregado</h4>
                    <tr class="center">

                        <td class='center'>Id_usuario</td>
                        <td class='center'>Escolaridade</td>
                        <td class='center'>Area_atuacao</td>
                        <td class='center'>Nota</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $empregadoPDO->selectEmpregado();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $empregado = new empregado($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $empregado->getId_usuario()?></td>
                            <td class="center"><?php echo $empregado->getEscolaridade()?></td>
                            <td class="center"><?php echo $empregado->getArea_atuacao()?></td>
                            <td class="center"><?php echo $empregado->getNota()?></td>
                            <td class = 'center'><a href="./editarEmpregado.php?id=<?php echo $empregado->getid_usuario()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/empregadoControle.php?function=deletar&id=<?php echo $empregado->getid_usuario()?>">Excluir</a></td>
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

