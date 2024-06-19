<?php
$page_title = "Produto";
include_once "layout/layout_header.php";
include_once "fachada.php";
?>

<div class="container mt-5">
    <h2 class="mb-4">Carrinho de Compras</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="https://via.placeholder.com/300" alt="Imagem do Produto" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title">Nome do Produto</h5>
                            <p class="card-text text-muted">Preço: $100</p>
                            <div class="input-group mb-3" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="text" class="form-control text-center" value="1">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                            <button class="btn btn-outline-danger">Remover <i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="https://via.placeholder.com/300" alt="Imagem do Produto" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title">Nome do Produto</h5>
                            <p class="card-text text-muted">Preço: $100</p>
                            <div class="input-group mb-3" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="text" class="form-control text-center" value="1">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                            <button class="btn btn-outline-danger">Remover <i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="https://via.placeholder.com/300" alt="Imagem do Produto" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title">Nome do Produto</h5>
                            <p class="card-text text-muted">Preço: $100</p>
                            <div class="input-group mb-3" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="text" class="form-control text-center" value="1">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                            <button class="btn btn-outline-danger">Remover <i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card position-sticky top-0">
                <div class="card-body">
                    <h5 class="card-title">Resumo do Carrinho</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (3 itens)</span>
                            <strong>$200</strong>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-primary btn-lg btn-block">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// layout do rodapé
include_once "layout/layout_footer.php";
?>
