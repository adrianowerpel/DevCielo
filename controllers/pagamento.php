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

session_start();
$idProduto = $_SESSION['produto'][0]->id_produto;
$codigoCliente = $_SESSION['cliente'][0]->codigo;
$idCartao = $_SESSION['cartao'][0]->id_cartao;
$totalVenda = intval($_POST['valor']);

$vendaDAO = new VendaDAO();

$paymentId = '';
$merchantOrderID = '';
$tipoPagamento = $_POST['tipo'];
$ultimoID = $vendaDAO->getUltimoID();
$merchantOrderID = $ultimoID + 1;

// Configure o ambiente
$environment = $environment = Environment::sandbox();

// Configure seu merchant
$merchant = new Merchant('535a6d5b-ce8e-4e7c-b2de-bbd8be9d0b54', 'ZNTHHOFTTZNBGLJPCTQSKGJDHQQJNLDJKAUXYBGZ');

if($tipoPagamento = 'credito') {
    // Crie uma instância de Sale informando o ID do pedido na loja
    $sale = new Sale($merchantOrderID);
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
}

if($tipoPagamento = 'boleto'){

    // Crie uma instância de Sale informando o ID do pedido na loja
    $sale = new Sale($merchantOrderID);
    $merchantOrderID = $sale->getMerchantOrderId();

    // Crie uma instância de Customer informando o nome do cliente,
// documento e seu endereço
    $customer = $sale->customer($_POST['nome_cliente'])
        ->setIdentity('00000000001')
        ->setIdentityType('CPF')
        ->address()->setZipCode('22750012')
        ->setCountry('BRA')
        ->setState($_SESSION['endereco'][0]->uf)
        ->setCity($_SESSION['endereco'][0]->cidade)
        ->setDistrict($_SESSION['endereco'][0]->bairro)
        ->setStreet($_SESSION['endereco'][0]->logradouro)
        ->setNumber($_SESSION['endereco'][0]->numero);

// Crie uma instância de Payment informando o valor do pagamento
    $payment = $sale->payment(15700)
        ->setType(Payment::PAYMENTTYPE_BOLETO)
        ->setAddress($_SESSION['endereco'][0]->logradouro)
        ->setBoletoNumber('1234')
        ->setAssignor('Empresa de Teste')
        ->setDemonstrative('Desmonstrative Teste')
        ->setExpirationDate(date(new DateTime(), strtotime('+1 month')))
        ->setIdentification('11884926754')
        ->setInstructions('Esse é um boleto de exemplo');

// Crie o pagamento na Cielo
    try {
        // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
        $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

        // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
        // dados retornados pela Cielo
        $paymentId = $sale->getPayment()->getPaymentId();
        $boletoURL = $sale->getPayment()->getUrl();

        header('Location: '.$boletoURL);
    } catch (CieloRequestException $e) {
        // Em caso de erros de integração, podemos tratar o erro aqui.
        // os códigos de erro estão todos disponíveis no manual de integração.
        $error = $e->getCieloError();
    }
}

$teste = $vendaDAO->salvaVenda($idProduto, $codigoCliente, $idCartao, $totalVenda, $paymentId, $merchantOrderID);