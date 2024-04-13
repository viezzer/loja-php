<?php
include_once "fachada.php";

// Verifica se os campos obrigatórios estão preenchidos
if(isset($_POST['id'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address_id'], $_POST['street'], $_POST['number'], $_POST['neighborhood'], $_POST['zip_code'], $_POST['city'], $_POST['state'])) {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address_id = $_POST['address_id'];
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
        header("Location: fornecedor.php?msg=empty&id={$id}&edit=");
        exit;
    }
    
    // Cria o objeto endereço
    $address = new Address($address_id, $street, $number, $complement, $neighborhood, $zip_code, $city, $state);
    $addressDao = $factory->getAddressDao();
    
    // Atualiza o endereço
    if (!$addressDao->update($address)) {
        header("Location: fornecedor.php?msg=address_update_error&id={$id}&edit=");
        exit;
    }

    // Cria o objeto fornecedor e atualiza no banco de dados
    $supplier = new Supplier($id, $name, $description, $phone, $email, $address);
    $supplierDao = $factory->getSupplierDao();
    
    // Atualiza o fornecedor
    if (!$supplierDao->update($supplier)) {
        header("Location: fornecedor.php?msg=supplier_update_error&id={$id}&edit=");
        exit;
    }
    
    // Redireciona para a página de listagem de fornecedores
    header("Location: fornecedores.php?msg=supplier_updated");
    exit;

} else {
    // Se algum campo estiver faltando, redireciona de volta ao formulário
    header("Location: fornecedor.php?msg=missing_fields&id={$_POST['id']}&edit=");
    exit;
}

?>
