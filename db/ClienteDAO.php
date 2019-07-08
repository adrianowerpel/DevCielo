<?php
require_once 'connection.php';

class ClienteDAO
{
    public function getByLogin($usuario,$senha){
        global $pdo;
        $query = "SELECT * FROM cliente WHERE usuario = '".$usuario."' AND senha = '".$senha."';";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $cliente = $statement->fetchAll(PDO::FETCH_OBJ);

        return $cliente;
    }

    public function getEnderecoCliente($idCliente){
        global $pdo;
        $query = "SELECT * FROM endereco WHERE codigo_cliente = '".$idCliente."';";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $endereco = $statement->fetchAll(PDO::FETCH_OBJ);

        return $endereco;
    }

    public function getCartaoCliente($idCliente){
        global $pdo;
        $query = "SELECT * FROM cartao WHERE codigo_cliente = '".$idCliente."';";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $cartao = $statement->fetchAll(PDO::FETCH_OBJ);

        return $cartao;
    }
}