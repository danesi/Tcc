<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem Administrador</title>
        <?php
            include_once '../Base/header.php';
            include_once '../Controle/administradorPDO.php';
            include_once '../Modelo/Administrador.php';
            $administradorPDO = new administradorPDO();
        ?>
        <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <main>
            <div class="row " style="margin-top: 5vh;">
                <table class=" card col s10 offset-s1 center">
                <h4 class='center'>Listagem Administrador</h4>
                    <tr class="center">

                        <td class='center'>Id_usuario</td>
                        <td class='center'>Admin</td>
                        <td class='center'>Editar</td>
                        <td class='center'>Excluir</td>
                    </tr>
                    <?php
                    $stmt = $administradorPDO->selectAdministrador();
                        
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $administrador = new administrador($linha);
                            ?>
                        <tr>
                            <td class="center"><?php echo $administrador->getId_usuario()?></td>
                            <td class="center"><?php echo $administrador->getAdmin()?></td>
                            <td class = 'center'><a href="./editarAdministrador.php?id=<?php echo $administrador->getid_usuario()?>">Editar</a></td>
                            <td class="center"><a href="../Controle/administradorControle.php?function=deletar&id=<?php echo $administrador->getid_usuario()?>">Excluir</a></td>
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

