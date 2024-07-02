<?php
session_start();

require_once "fachada.php";
$dao = $factory->getOrderDao();

$error_messages = [];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error_messages[] = 'ID do pedido não fornecido.';
} else {
    $order_id = $_GET['id'];

    $order = $dao->getOrderByNumber($order_id);

    if (!$order) {
        $error_messages[] = 'Pedido não encontrado.';
    } else {
        $order_data = json_decode($order, true);

        if (!$order_data) {
            $error_messages[] = 'Erro ao decodificar os dados do pedido.';
        }


        if (!isset($_SESSION['loggedin'], $_SESSION['user_role'], $_SESSION['user_name'])) {
            $error_messages[] = 'Usuário não autenticado.';
        } else {
            $authorized = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_name'] === $order_data['client_name']);

            if (!$authorized) {
                $error_messages[] = 'Você não está autorizado a visualizar este pedido.';
            }
        }
    }
}

include_once "layout/layout_header.php";
?>

<div class="container mt-4">
    <?php if (!empty($error_messages)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($error_messages as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h2>Detalhes do Pedido <?php echo isset($order_id) ? $order_id : ''; ?></h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
            <tr>
                    <th style="width: 30%;">Número do Pedido</th>
                    <td><?php echo $order_data["id"]; ?></td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td><?php echo $order_data["client_name"]; ?></td>
                </tr>
                <tr>
                    <th>Data do Pedido</th>
                    <td><?php echo $order_data["orderDate"]; ?></td>
                </tr>
                <tr>
                    <th>Data de Entrega</th>
                    <td><?php echo $order_data["deliveryDate"]; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $order_data["status"]; ?></td>
                </tr>
                <tr>
                    <th>Itens</th>
                    <td>
                        <ul>
                            <?php foreach ($order_data["items"] as $item): ?>
                                <li>
                                    <?php echo $item["product_name"]; ?> -
                                    Quantidade: <?php echo $item["quantity"]; ?> -
                                    Preço: R$<?php echo number_format($item["price"], 2); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>

            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <div class="mt-3">
                    <a href="atualiza_pedido.php?id=<?php echo $order_id; ?>" class="btn btn-primary">Editar Pedido</a>
                    <a href="excluir_pedido.php?id=<?php echo $order_id; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este pedido?')">Deletar Pedido</a>
                </div>
            <?php endif; ?>

            <?php if ($_SESSION['user_name'] === $order_data['client_name'] && $order_data['status']!== "CANCELADO"): ?>
                <div class="mt-3">
                    <a href="cancela_pedido.php?id=<?php echo $order_id; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar este pedido?')">Cancelar Pedido</a>
                </div>
            <?php endif; ?>
            
        </div>
    <?php endif; ?>
</div>

<?php
include_once "layout/layout_footer.php";
?>
