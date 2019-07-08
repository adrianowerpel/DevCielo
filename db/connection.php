<?php

try {
    $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=aula_pos','postgres','postgres');
    $pdo->exec("set names utf8");
} catch ( PDOException $e ) {
    echo  'Erro ao conectar com o Banco: ' . $e->getMessage();
    exit(1);
}
