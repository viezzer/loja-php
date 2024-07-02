<?php
session_start();

$page_title = "Carrinho de Compras";
include_once "layout/layout_header.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Carrinho de Compras</h2>
    
    <div class="row">
        <div class="col-md-8">
            <?php
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
            ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="https://via.placeholder.com/300" alt="Imagem do Produto" class="img-fluid rounded-start">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text text-muted">Preço: <?php echo $item['price']; ?> R$</p>
                                <p class="card-text text-muted">Estoque: <?php echo $item['stock_quantity']; ?> </p>
                                <div class="input-group mb-3" style="max-width: 150px;">
                                    <button class="btn btn-outline-secondary btn-decrease" data-product-id="<?php echo $item['id']; ?>" type="button">-</button>
                                    <input type="number" class="form-control text-center quantity-input" data-product-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>">
                                    <button class="btn btn-outline-secondary btn-increase" data-product-id="<?php echo $item['id']; ?>" type="button">+</button>
                                </div>
                                <form method="post" action="excluir_carrinho.php">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger">Remover <i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                          Seu carrinho está vazio. <a href="index.php" class="alert-link">Adicione itens agora!</a>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            ?>
        </div>
        
        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="col-md-4">
            <div class="card position-sticky top-0">
                <div class="card-body">
                    <h5 class="card-title">Resumo do Carrinho</h5>
                    <ul class="list-group mb-3">
                        <?php
                        $total_items = 0;
                        $total_price = 0;
                        
                        foreach ($_SESSION['cart'] as $item) {
                            $total_items += $item['quantity'];
                            $total_price += $item['price'] * $item['quantity'];
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (<?php echo $total_items; ?> itens)</span>
                            <strong><?php echo number_format($total_price, 2); ?> R$</strong>
                        </li>
                    </ul>
                    <form method="post" action="finalizar_compra.php">
    <button type="submit" class="btn btn-primary btn-lg btn-block">Finalizar Compra</button>
</form>

                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
include_once "layout/layout_footer.php";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-increase').click(function() {
        var productId = $(this).data('product-id');
        var quantityInput = $(this).closest('.input-group').find('.quantity-input');
        var newQuantity = parseInt(quantityInput.val()) + 1;
        
        updateCart(productId, newQuantity, quantityInput);
    });

    $('.btn-decrease').click(function() {
        var productId = $(this).data('product-id');
        var quantityInput = $(this).closest('.input-group').find('.quantity-input');
        var newQuantity = parseInt(quantityInput.val()) - 1;

        if (newQuantity >= 1) {
            updateCart(productId, newQuantity, quantityInput);
        }
    });

    $('.quantity-input').change(function() {
        var productId = $(this).data('product-id');
        var newQuantity = parseInt($(this).val());

        if (!isNaN(newQuantity) && newQuantity >= 1) {
            updateCart(productId, newQuantity, $(this));
        } else {

            $(this).val($(this).data('previous-value'));
        }
    });

    function updateCart(productId, newQuantity, quantityInput) {
    // Store previous value
    quantityInput.data('previous-value', quantityInput.val());

    // Verifica se a nova quantidade não é maior que o estoque
    var maxQuantity = parseInt(quantityInput.closest('.card-body').find('.card-text.text-muted:eq(1)').text().replace('Estoque: ', '').trim());
    if (newQuantity > maxQuantity) {
        alert('A quantidade selecionada excede o estoque disponível.');
        quantityInput.val(maxQuantity); // Define o valor máximo disponível no estoque
        return;
    }

    quantityInput.val(newQuantity);

    $.ajax({
        url: 'atualiza_carrinho.php',
        method: 'POST',
        data: { product_id: productId, quantity: newQuantity },
        success: function(response) {
            console.log('Carrinho atualizado com sucesso.');
            // Recarrega a página após a atualização do carrinho
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Erro ao atualizar o carrinho:', error);
            // Em caso de erro, reverta para o valor máximo disponível no estoque
            quantityInput.val(maxQuantity);
        }
    });
}
});
</script>
