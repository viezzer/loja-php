<?php
$page_title = "Usuários";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";
include_once "fachada.php";

$limit = 5; // Número de itens por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// procura usuarios
$dao = $factory->getUserDao();

$search_id = isset($_GET['search_id']) ? $_GET['search_id'] : null;
$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : null;

$users = $dao->getAll($search_id, $search_name, $limit, $offset);

$total_items = $dao->countAll($search_id, $search_name);
$total_pages = ceil($total_items / $limit);

?>
<div class="container py-4">
    <!-- Banner de alerta -->
    <div class="row">
        <div class="col">
        <?php
                // Verifica se a variável 'msg' está presente na URL
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];

                    // Mensagem de erro correspondente ao valor da variável 'msg'
                    $messages = [
                        'user_deleted' => 'Usuário deletado.',
                        'user_updated' => 'Usuário atualizado.',
                        'missing_fields' => 'Alguns campos estão faltando. Por favor, preencha todos os campos.',
                        'database_error' => 'Erro no servidor.',
                        'user_update_error' => 'Erro ao atualizar usuário.',
                        'user_delete_error' => 'Erro ao deletar usuário'
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
            ?>
        </div>
    </div>
    <!-- botões -->
    <div class="row mb-3">
        <div class="col-md-6">
            <a class="btn btn-success btn-sm mb-2" href="novo_usuario.php">Novo Usuário</a>
        </div>
        <div class="col-md-6">
            <form action="usuarios.php" method="get">
                <div class="row">
                    <div class="col-lg-2 mb-2">
                        <button type='submit' class='btn btn-sm btn-primary '>Pesquisar</button>
                    </div>
                    <div class="col-lg-7">
                        <input type="text" class="form-control form-control-sm mb-2" id='search_name' name='search_name' placeholder="<?php echo (isset($_GET['search_name']) && $_GET['search_name']) ? $_GET['search_name'] : 'Nome' ?>">
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm mb-2" id='search_id' name='search_id' placeholder="<?php echo (isset($_GET['search_id']) && $_GET['search_id']) ? $_GET['search_id'] : 'ID' ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- listagem de usuários -->
    <div class="row">
        <div class="col">
            <legend>Lista de usuários</legend>
            <?php
                if($users) {
                    echo '<table class="table table-striped table-bordered table-responsive">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th scope="col">ID</th>';
                                echo '<th scope="col">Nome</th>';
                                echo '<th scope="col">Login</th>';
                                echo '<th scope="col">Tipo de usuário</th>';
                            echo '</tr>';
                        echo '</thead>';
                    echo '<tbody>';
                    foreach($users as $user) {
                        echo '<tr>';
                        echo "<th scope='row'>{$user->getId()}</th>";
                        echo "<td><a href='usuario.php?id={$user->getId()}'>{$user->getName()}</a></td>";
                        echo "<td>{$user->getLogin()}</td>";
                        echo "<td>{$user->getRole()}</td>";
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo 'Nenhum usuário encontrado';
                }
                // Links de paginação
                if ($total_pages > 1) {
                    echo '<nav>';
                    echo '<ul class="pagination">';
                    // Botão para a primeira página
                    echo '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">';
                    echo '<a class="page-link" href="usuarios.php?page=1&search_id='. $search_id .'&search_name='. $search_name .'">Primeira</a>';
                    echo '</li>';

                    // Botões de páginas numeradas
                    $start_page = max(1, $page - 1);
                    $end_page = min($total_pages, $page + 1);

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                        echo '<a class="page-link" href="usuarios.php?page=' . $i . '&search_id='. $search_id .'&search_name='. $search_name .'">' . $i . '</a>';
                        echo '</li>';
                    }
                    // Botão para a última página
                    echo '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '">';
                    echo '<a class="page-link" href="usuarios.php?page=' . $total_pages . '&search_id='. $search_id .'&search_name='. $search_name .'">Última ('. $total_pages . ')</a>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</nav>';
                }
            ?>
        </div>
    </div>
</div>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
