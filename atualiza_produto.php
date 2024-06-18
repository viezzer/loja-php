<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['id'],$_POST['name'], $_POST['description'], $_POST['supplier_id'],$_POST['quantity'],$_POST['price'])) {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $supplier_id = $_POST['supplier_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if(isset($_FILES['image'])){
        $image = $_FILES['image'];
    }

    // Validações adicionais
    if (empty($id) || empty($name) || empty($description) || empty($supplier_id)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        var_dump($id,$name,$description,$supplier_id,$quantity,$price);
        echo empty($name);
        exit;
        header("Location: produto.php?msg=empty&id={$id}&edit=");
        exit;
    }
    
    // Cria o objeto produto e atualiza no banco de dados
    $supplier = new Supplier($supplier_id,null,null,null,null,null);
    $product = new Product($id, $name, $description, $supplier,null);
    $stock = new Stock(null,$quantity,$price,$product);
    $product->setStock($stock);
    $productDao = $factory->getProductDao();
    $stockDao = $factory->getStockDao();

    $base64Image = null;

    // Processa a imagem se ela foi enviada
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $base64Image = base64_encode($imageData);
    }

    // Se a imagem foi enviada, seta a imagem no objeto produto
    if ($base64Image) {
        $product->setImage($base64Image);
    }

    // Atualiza o produto
    if (!$productDao->update($product)) {
        header("Location: produto.php?msg=product_update_error&id={$id}&edit=");
        exit;
    }
    
    // Redireciona para a página de listagem de produtoes
    header("Location: produtos.php?msg=product_updated");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: produto.php?msg=missing_fields&id={$_POST['id']}&edit=");
    exit;
}

?>
