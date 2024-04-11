<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['name'], $_POST['description'], $_POST['phone'], $_POST['email'], $_POST['street'], $_POST['number'], $_POST['complement'], $_POST['neighborhood'], $_POST['zip_code'], $_POST['city'], $_POST['state'])) {
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
    if (empty($name) || empty($description) || empty($phone) || empty($email) || empty($address_id) || empty($street) || empty($number) || empty($neighborhood) || empty($zip_code) || empty($city) || empty($state)) {
        // Se algum campo obrigatório estiver vazio, redireciona de volta ao formulário
        header("Location: novo_supplier.php?error=empty");
        exit;
    }

    // Exemplo de validação de formato de e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se o e-mail não estiver no formato correto, redireciona com um erro
        header("Location: novo_supplier.php?error=invalid_email");
        exit;
    }
    
    // Cria o objeto endereço
    $address = new Address(null, $street, $number, $complement, $neighborhood, $zip_code, $city, $state);
    $addressDao = $factory->getAddressDao();
    $addressDao->insert($address);
    
    // Cria o objeto fornecedor e insere no banco de dados
    $supplier = new Supplier(null, $name, $description, $phone, $email, $address);
    $supplierDao = $factory->getSupplierDao();
    $supplierDao->insert($supplier);
    
    // Redireciona para a página de listagem de fornecedores
    header("Location: lista_fornecedores.php");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: novo_supplier.php?error=missing_fields");
    exit;
}

?>
