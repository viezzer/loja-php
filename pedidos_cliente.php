<?php
session_start();
$page_title = "Meus Pedidos";
include_once 'verifica.php';
// layout do cabeçalho
include_once "layout/layout_header.php";

$client_name = $_SESSION['user_name']; // Supondo que o nome do cliente está armazenado na sessão
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
    <!-- listagem de pedidos -->
    <div class="row">
        <div class="col">
            <legend>Meus pedidos</legend>
            <div id="orders-container">
                <!-- A tabela será preenchida pelo JavaScript -->
            </div>
        </div>
    </div>
</div>
<script>
    const clientName = "<?php echo $client_name; ?>";
</script>
<script src="js/orders.js"></script>
<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
