<?php
require '../vendor/autoload.php';
require_once '../db/VendaDAO.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;

$paymentId = '';
$merchantOrderID = '';

// Configure o ambiente
$environment = $environment = Environment::sandbox();

// Configure seu merchant
$merchant = new Merchant('535a6d5b-ce8e-4e7c-b2de-bbd8be9d0b54', 'ZNTHHOFTTZNBGLJPCTQSKGJDHQQJNLDJKAUXYBGZ');

// Crie uma instância de Sale informando o ID do pedido na loja
$sale = new Sale('125');
$merchantOrderID = $sale->getMerchantOrderId();

// Crie uma instância de Customer informando o nome do cliente
$customer = $sale->customer($_POST['nome_cliente']);

// Crie uma instância de Payment informando o valor do pagamento
$payment = $sale->payment(intval($_POST['valor']));

// Crie uma instância de Credit Card utilizando os dados de teste
// esses dados estão disponíveis no manual de integração
$payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
    ->creditCard($_POST['cvc'], CreditCard::VISA)
    ->setExpirationDate($_POST['validade'])
    ->setCardNumber($_POST['num_cartao'])
    ->setHolder($_POST['nome_cliente']);

// Crie o pagamento na Cielo
try {
    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
    // dados retornados pela Cielo
    $paymentId = $sale->getPayment()->getPaymentId();

    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
    $sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, 15700, 0);
    // E também podemos fazer seu cancelamento, se for o caso
   // $sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);
} catch (CieloRequestException $e) {
    // Em caso de erros de integração, podemos tratar o erro aqui.
    // os códigos de erro estão todos disponíveis no manual de integração.
    $error = $e->getCieloError();
}

$vendaDAO = new VendaDAO();

session_start();
$idProduto = $_SESSION['produto'][0]->id_produto;
$codigoCliente = $_SESSION['cliente'][0]->codigo;
$idCartao = $_SESSION['cartao'][0]->id_cartao;
$totalVenda = intval($_POST['valor']);

$teste = $vendaDAO->salvaVenda($idProduto, $codigoCliente, $idCartao, $totalVenda, $paymentId, $merchantOrderID);