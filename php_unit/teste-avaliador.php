<?php

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Services\Avaliador;

require __DIR__ . '/vendor/autoload.php';

$leilao = new Leilao('Fiat Punto');

$maria = new Usuario('maria');
$joao = new Usuario('Joao');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

echo $maiorValor = $leiloeiro->getMaiorValor();