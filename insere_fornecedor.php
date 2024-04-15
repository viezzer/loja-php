<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['street'], $_POST['number'], $_POST['neighborhood'], $_POST['zip_code'], $_POST['city'], $_POST['state'])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $street = $_POST["street"];
    $number = $_POST["number"];
    $complement = $_POST["complement"];
    $neighborhood = $_POST["neighborhood"];
    $zip_code = $_POST["zip_code"];
    $city = $_POST["city"];
    $state = $_POST["state"];

    // Validações adicionais
    if (empty($name) || empty($phone) || empty($email) || empty($street) || empty($number) || empty($neighborhood) || empty($zip_code) || empty($city) || empty($state)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        header("Location: novo_fornecedor.php?msg=empty");
        exit;
    }
    
    // Cria o objeto endereço
    $address = new Address(null, $street, $number, $complement, $neighborhood, $zip_code, $city, $state);
    // Cria o objeto fornecedor e insere no banco de dados
    $supplier = new Supplier(null, $name, $description, $phone, $email, $address);
    $supplierDao = $factory->getSupplierDao();
    if(!$supplierDao->insert($supplier)) {
        header("Location: novo_fornecedor.php?msg=database_error");
    }
    
    // Redireciona para a página de listagem de fornecedores
    header("Location: fornecedores.php");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: novo_fornecedor.php?msg=missing_fields");
    exit;
}

?>
