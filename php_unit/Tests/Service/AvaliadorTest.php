<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Services\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private Avaliador $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    public function testLeilaoVazioNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('não é possivel avaliar um leilao vazio');
        $leilao = new Leilao('fusca');
        $this->leiloeiro->avalia($leilao);

    }


    /**
     * @dataProvider entregaLeiloes
     */
    public function testAvaliadorDeveEncontrarOMaiorValor(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(2000, $maiorValor);
    }

    /**
     * @dataProvider entregaLeiloes
     */
    public function testAvaliadorDeveBuscarTresMaioresValores(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        self::assertCount(3, $maiores);
        self::assertEquals(2000, $maiores[0]->getValor());
        self::assertEquals(1700, $maiores[1]->getValor());
        self::assertEquals(1500, $maiores[2]->getValor());
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Leilão já finalizado');
        $leilao = new Leilao('punto');
        $leilao->recebeLance(new Lance(new Usuario('teste'), 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
    }

    public function leilaoEmOrdemCrescente() 
    {
        $leilao = new Leilao('Fiat 147');
        $jao = new Usuario('jao');
        $ana = new Usuario('ana');
        $lu = new Usuario('Lu');
        $jo = new Usuario('JO');
        
        $leilao->recebeLance(new Lance($jao, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));
        $leilao->recebeLance(new Lance($jo, 1700));
        $leilao->recebeLance(new Lance($lu, 2000));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        return [$leilao];
    }

    public function leilaoEmOrdemDecrescente() 
    {
        $leilao = new Leilao('Fiat 147');
        $jao = new Usuario('jao');
        $ana = new Usuario('ana');
        $lu = new Usuario('Lu');
        $jo = new Usuario('JO');
        
        $leilao->recebeLance(new Lance($lu, 2000));
        $leilao->recebeLance(new Lance($jo, 1700));
        $leilao->recebeLance(new Lance($ana, 1500));
        $leilao->recebeLance(new Lance($jao, 1000));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        return [$leilao];
    }

    public function entregaLeiloes() 
    {
        return [
            $this->leilaoEmOrdemCrescente(),
            $this->leilaoEmOrdemDecrescente(),
        ];
    }
}