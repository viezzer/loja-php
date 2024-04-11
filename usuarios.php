<?php
$page_title = "Usuários";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura usuarios
$dao = $factory->getUserDao();
$users = $dao->getAll();

?>
<div class="container py-4">
    <?php
        if($users) {
            echo '<table class="table table-striped table-bordered table-responsive">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th scope="col">ID</th>';
                        echo '<th scope="col">Nome</th>';
                        echo '<th scope="col">Login</th>';
                    echo '</tr>';
                echo '</thead>';
            echo '<tbody>';
            foreach($users as $user) {
                echo '<tr>';
                  echo "<th scope='row'>{$user->getId()}</th>";
                  echo "<td>{$user->getName()}</td>";
                  echo "<td>{$user->getLogin()}</td>";
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'Nenhum usuário encontrado';
        }
    ?>
    
</div >
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
