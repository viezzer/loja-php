<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getTurmaDao();

$request_method=$_SERVER["REQUEST_METHOD"];
	
switch($request_method)
 {
 case 'GET':
    // Busca todas as turmas
    if(!empty($_GET["id"]))
    {
        $id=intval($_GET["id"]);
        $turmaJSON = $dao->buscaTurmaJSON($id);
        if($turmaJSON!=null) {
            echo $turmaJSON;
            http_response_code(200); // 200 OK
        } else {
            http_response_code(404); // 404 Not Found
        }
    } //Busca uma turma
    else
    {
        echo $dao->buscaTurmasJSON();
        http_response_code(200); // 200 OK
    }
    break;
 case 'POST':
    // insere uma turma
    $data = json_decode(file_get_contents('php://input'), true);
    $codTurma = $data["codigo"];
    $nomeProfessor = $data["professor"];
    $horario = $data["horario"];
    $id_curso = @$data["id_curso"];
    $turma = new Turma(null,$codTurma,$nomeProfessor,$horario,$id_curso);
    $dao->insere($turma);
    http_response_code(201); // 201 Created
    break;
 case 'PUT':
    if(!empty($_GET["id"]))
    {
       $id=intval($_GET["id"]);
       $turma = $dao->buscaPorId($id);
       if($turma!=null) {
            $data = json_decode(file_get_contents('php://input'), true);
            $turma->setCodigo($data["codigo"]);
            $turma->setProfessor($data["professor"]);
            $turma->setHorario($data["horario"]);
            $turma->setId_curso($data["id_curso"]);
            $dao->altera($turma);
            http_response_code(200); // 200 OK
       } else {
        http_response_code(404); // 404 Not Found
       }
    }
    break;
 case 'DELETE':
    if(!empty($_GET["id"]))
    {
       $id=intval($_GET["id"]);
       $dao->remove($id);
       http_response_code(204); // 204 Deleted
    }
    break;
 default:
    // Invalid Request Method
    http_response_code(405); // 405 Method Not Allowed
    break;
 }