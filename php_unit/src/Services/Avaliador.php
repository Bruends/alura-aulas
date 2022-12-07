<?php

namespace Alura\Leilao\Services;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Exception;

class Avaliador
{
    
    private $maiorValor = 0;
    private $menorValor = INF;
    private $maioresLances;

    public function avalia(Leilao $leilao)
    {   
        if ($leilao->estaFinalizado()) {
            throw new \DomainException('Leilão já finalizado');
        }

        if(empty($leilao->getLances())) {
            throw new \DomainException('não é possivel avaliar um leilao vazio');
        }

        foreach ($leilao->getLances() as $lance){
            if($lance->getValor() > $this->maiorValor){
                $this->maiorValor = $lance->getValor();
            }
            
            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }
        }

        $lances = $leilao->getLances();
        usort($lances, function(Lance $lance1, Lance $lance2){
            return $lance2->getValor() - $lance1->getValor();
        });

        $this->maioresLances = array_slice($lances, 0, 3);

    }

    public function getMaiorValor() {
        return $this->maiorValor;
    }

    public function getMenorValor() {
        return $this->menorValor;
    }

    public function getMaioresLances() {
        return $this->maioresLances;
    }
}
