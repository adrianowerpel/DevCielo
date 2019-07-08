<?php

require_once '../db/connection.php';
require_once '../db/ProdutoDAO.php';
require_once 'template.php';

$template = new template();
$produtoDAO = new ProdutoDAO();
$produtos = $produtoDAO->getAll();

$template->header();

?>

<table class="table align-content-center" style="text-align: center;width: 70%;margin-left: 10%">
    <tr>
        <th>Nome</th>
        <th>Valor</th>
        <th>Imagem</th>
        <th>Comprar</th>
    </tr>
    <?php
        foreach ($produtos as $produto){
            echo '<tr>';
            echo '<td>'. $produto->nome .'</td>';
            echo '<td>'. $produto->valor .'</td>';
            echo '<td><img src="../assets/images/'.$produto->name_image.'.png" style="width: 200px"></td>';
            echo '<td><button type="submit"  id="'.$produto->id_produto.'" onclick="comprar(this)">Comprar</button></td>';
            echo '</tr>';
        }
    ?>
</table>

<?php
$template->footer();
?>

<script>
    function comprar(id) {
        window.open("venda_produto.php?id="+id.id);
    }
</script>
