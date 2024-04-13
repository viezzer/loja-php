<?php
include_once "fachada.php";
// Validação dos dados recebidos do formulário
$name = trim($_POST["name"]);
$description = trim($_POST["description"]);
$supplier_id = $_POST["supplier_id"];

// Verifica se todos os campos estão preenchidos
if (empty($name) || empty($supplier_id)) {
    $msg = "empty";
    header("Location: novo_produto.php?msg=$msg");
    exit();
}

// Cria um novo objeto Produto
$product = new Product(null, $name, $description, null, null);

// Define o fornecedor do produto
$supplierDao = $factory->getSupplierDao();
$supplier = $supplierDao->getById($supplier_id);
if (!$supplier) {
    header("Location: novo_produto.php?msg=supplier_not_found");
    exit();
}
$product->setSupplier($supplier);

// Salva o produto no banco de dados
$productDao = $factory->getProductDao();
$success = $productDao->insert($product);

if ($success) {
    // Produto cadastrado com sucesso
    header("Location: produtos.php?msg=product_created");
    exit();
} else {
    // Erro ao cadastrar o produto
    header("Location: novo_produto.php?msg=database_error");
    exit();
}
?>