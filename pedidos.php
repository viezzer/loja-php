<?php
session_start();


if (!(isset($_SESSION['user_name']) && $_SESSION['user_name'] != 'admin')) {

    echo "Acesso Negado. Você deve ser um administrador para acessar essa pagina";

    exit; 
}

$page_title = "Pedidos";
include_once 'verifica.php';
include_once "layout/layout_header.php";

$client_name = isset($_GET['client_name']) ? $_GET['client_name'] : '';
$order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';

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
                    'order_created' => 'Pedido cadastrado.',
                    'order_deleted' => 'Pedido deletado.',
                    'order_updated' => 'Pedido atualizado.',
                    'database_error' => 'Erro no servidor.',
                    'order_update_error' => 'Erro ao atualizar pedido.',
                    'order_delete_error' => 'Erro ao deletar pedido'
                ];

                // Verifica se a chave 'msg' existe no array de mensagens de erro
                if (array_key_exists($msg, $messages)) {
                    // Exibe a mensagem de erro
                    if($msg=='order_created' || $msg=='order_updated'){
                        echo '<div class="alert alert-success" role="alert">' . $messages[$msg] . '</div>';
                    } else {
                        echo '<div class="alert alert-warning" role="alert">' . $messages[$msg] . '</div>';
                    }
                } else {
                    // Mensagem de erro padrão caso o código de erro não seja reconhecido
                    echo '<div class="alert alert-warning" role="alert">Erro desconhecido.</div>';
                }
            }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="pedidos.php" method="get">
                <div class="row">
                    <div class="col-lg-2 mb-2">
                        <button type='submit' class='btn btn-sm btn-primary '>Pesquisar</button>
                    </div>
                    <div class="col-lg-7">
                        <input type="text" class="form-control form-control-sm mb-2" id='client_name' name='client_name' placeholder="<?php echo (isset($_GET['client_name']) && $_GET['client_name']) ? $_GET['client_name'] : 'Nome' ?>">
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control form-control-sm mb-2" id='order_number' name='order_number' placeholder="<?php echo (isset($_GET['order_number']) && $_GET['order_number']) ? $_GET['order_number'] : 'ID' ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- listagem de pedidos -->
    <div class="row">
        <div class="col">
            <legend>Todos os pedidos</legend>
            <div id="orders-container">
                <!-- A tabela será preenchida pelo JavaScript -->
            </div>
        </div>
    </div>
</div>
<script>
    const clientName = "<?php echo $client_name; ?>";
    const orderNumber = "<?php echo $order_number; ?>";
</script>
<script src="js/adminOrders.js"></script>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
