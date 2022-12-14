<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{

    public function testLeilaoNaoDeveReceberLancesRepetidos() 
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('usuário não pode propor 2 lances seguidos');
        $leilao = new Leilao('Variante');
        $ana = new Usuario('ana');

        $leilao->recebeLance(new Lance($ana, 2000));
        $leilao->recebeLance(new Lance($ana, 5000));

        self::assertCount(1, $leilao->getLances());
        self::assertEquals(2000, $leilao->getLances()[0]->getValor());

    }

    /**
     * @dataProvider geraLance
     */
    public function testLeilaoRecebeLance(int $qtdLances, Leilao $leilao, array $valores) 
    {
        self::assertCount($qtdLances, $leilao->getLances());
        foreach ($valores as $i => $valor) {
            self::assertEquals($valor, $leilao->getLances()[$i]->getValor());

        }
    }

    public function testLeilaoNaoDeveAceitarMaisDeCincoLancesPorUsuario()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('usuário não pode propor mais de 5 lances');
        $leilao = new Leilao('brasilia amarela');
        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));

        $leilao->recebeLance(new Lance($joao, 1000));
        $lances = $leilao->getLances();
        static::assertCount(10, $lances);
        $ultimoLance = $lances[array_key_last($lances)];
        static::assertEquals(5500, $ultimoLance->getValor());

    }

    public function geraLance()
    {
        $jao = new Usuario('jao');
        $maria = new Usuario('maria');
        
        $leilao2 = new Leilao('fiat punto');
        $leilao2->recebeLance(new Lance($jao, 2000));
        $leilao2->recebeLance(new Lance($maria, 1000));

        $leilao1 = new Leilao('fusca');
        $leilao1->recebeLance(new Lance($jao, 2000));

        return [
           '2 lances' => [2, $leilao2, [2000, 1000]],
           '1 Lance' => [1, $leilao1, [2000]]
        ];
    }
}