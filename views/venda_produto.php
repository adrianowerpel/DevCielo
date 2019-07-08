<?php

require_once '../db/ProdutoDAO.php';
require_once 'template.php';

$template = new template();

$produtoDAO = new ProdutoDAO();

$produto = $produtoDAO->getByID($_GET['id']);
session_start();
$cliente = $_SESSION['cliente'];
$endereco = $_SESSION['endereco'];
$cartao = $_SESSION['cartao'];
$_SESSION['produto'] = $produto;

$tipoCartao = $cartao[0]->cvc ? 'Credito' : 'Debito';

$template->header();

?>

    <div class="container" style="margin-top: 5%;margin-left: 40%">
        <form method="post" action="../controllers/pagamento.php">

            <div style="width: 50%">
                <h1>'<?php echo $produto[0]->nome ?>'</h1>

                <hr>
            </div>


            <div class="form-group">
                <img src="<?php echo '../assets/images/'.$produto[0]->name_image.'.png' ?>" width="300px">
            </div>

            <div class="form-group">
                <label for="qtd">Quantidade</label>
                <input type="text" class="form-control col-4" id="qtd" name="qtd">
            </div>

            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="text" class="form-control col-4" id="valor" name="valor" value="<?php echo $produto[0]->valor ?>" readonly>
            </div>

            <div style="width: 50%">
                <h1>Dados Compra</h1>

                <hr>
            </div>

            <div class="form-group">
                <label for="nome_cliente">Nome</label>
                <input type="text" class="form-control col-4" id="nome_cliente" name="nome_cliente" value="<?php echo $cliente[0]->nome ?>">
            </div>

            <div class="form-group">
                <label for="dt_nasc">Data de Nascimento</label>
                <input type="text" class="form-control col-4" id="dt_nasc" name="dt_nasc" value="<?php echo $cliente[0]->dt_nascimento ?>">
            </div>

            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control col-4" id="endereco" name="endereco" value="<?php echo $endereco[0]->logradouro. ' ' . $endereco[0]->numero . ' - ' . $endereco[0]->bairro . ', ' . $endereco[0]->cidade ?>">
            </div>

            <div class="form-group">
                <label for="num_cartao">Numero do Cartão</label>
                <input type="text" class="form-control col-4" id="num_cartao" name="num_cartao" value="<?php echo $cartao[0]->numero ?>">
            </div>

            <div class="form-group">
                <label for="validade">Validade do Cartão</label>
                <input type="text" class="form-control col-4" id="validade" name="validade" value="<?php echo $cartao[0]->validade ?>">
            </div>

            <div class="form-group">
                <label for="cvc">CVC do Cartão</label>
                <input type="text" class="form-control col-4" id="cvc" name="cvc" value="<?php echo $cartao[0]->cvc ?>">
            </div>

            <div class="form-group">
                <label for="tipo">Tipo de Pagamento</label>
                <select name="tipo">
                    <option value="credito">Crédito</option>
                    <option value="debito">Débito</option>
                    <option name="boleto">Boleto</option>
                </select>
            </div>

            <input type="submit" value="Comprar" class="btn btn-primary">

        </form>
    </div>


<?php
$template->footer();
?>
<script>
    $('#qtd').change(function () {
        var qtd = $('#qtd').val();
        var valor = $('#valor').val();
        var total = qtd * valor;
        $('#valor').val(total);
    });
</script>
