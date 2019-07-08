<?php

require_once '../db/ClienteDAO.php';

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$clienteDAO = new ClienteDAO();
$cliente = $clienteDAO->getByLogin($usuario,$senha);
$endereco = $clienteDAO->getEnderecoCliente($cliente[0]->codigo);
$cartao = $clienteDAO->getCartaoCliente($cliente[0]->codigo);

session_start();
$_SESSION['cliente'] = $cliente;
$_SESSION['endereco'] = $endereco;
$_SESSION['cartao'] = $cartao;

if(!empty($cliente[0]->codigo)){
    header('Location: ../views/produtos.php');
}
