<?php

require_once 'connection.php';

class ProdutoDAO
{
    public function getByID($id){

        global $pdo;
        $query = "SELECT * FROM produto WHERE id_produto = ".$id.";";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    public function getAll(){

        global $pdo;
        $query = "SELECT * FROM produto;";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}