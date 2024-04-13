<?php
$page_title = "Informações de Usuário";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";
// procura usuarios
if(!isset($_GET['id'])) {
    header('Location: usuarios.php');
}
$edit = 'disabled';
if(isset($_GET['edit'])) {
    $edit = $_GET['edit'];
}

$dao = $factory->getUserDao();
$user = $dao->getById($_GET['id']);

?>
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <?php
                echo "<a class='btn btn-secondary btn-sm' href='usuarios.php'>Voltar</a>";
                if($edit=='disabled') {
                    echo "<a href='?id={$_GET['id']}&edit= ' class='btn btn-primary btn-sm mx-2'>Editar</a>";
                } else {
                    echo "<a href='excluir_usuario.php?id={$_GET['id']}' class='btn btn-danger btn-sm mx-2'>Excluir</a>";
                }
            ?>
        </div>
    </div>
    <!-- listagem de usuarios -->
    <div class="row">
        <div class="col">
            <?php
                // Verifica se a variável 'msg' está presente na URL
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];

                    // Mensagem de erro correspondente ao valor da variável 'msg'
                    $messages = [
                        'empty' => 'Por favor, preencha todos os campos.',
                        'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                        'database_error' => 'Erro no servidor.',
                        'user_update_error' => 'Erro ao atualizar usuário.'
                    ];

                    // Verifica se a chave 'msg' existe no array de mensagens de erro
                    if (array_key_exists($msg, $messages)) {
                        // Exibe a mensagem de erro
                        echo '<div class="alert alert-warning" role="alert">' . $messages[$msg] . '</div>';
                    } else {
                        // Mensagem de erro padrão caso o código de erro não seja reconhecido
                        echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
                    }
                }
                echo '
                <form action="atualiza_usuario.php" method="post">
                    <legend>Cadastro de usuário</legend>
                    <input type="hidden" value="'.$user->getId().'" name="id">
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="name" value="'.$user->getName().'" '.$edit.'>
                        </div>
                        <div class="col-lg-6">
                            <label for="inputLogin" class="form-label">Login</label>
                            <input type="text" class="form-control" id="inputLogin" name="login" value="'.$user->getLogin().'" '.$edit.'>
                        </div>
                    </div>';
                    if($edit!='disabled') {
                        echo '<button type="submit" class="btn btn-success">Salvar</button>';
                    }
                    echo '</form>';
            ?>
        </div>
    </div >
</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
