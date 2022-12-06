<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if(!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            return;
        }

        $usuario = $lance->getUsuario();

        if ($this->totalLancesPorUsuario($usuario) >= 5){
            return;
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    private function ehDoUltimoUsuario(Lance $lance)
    {
        $ultimoLance = $this->lances[count($this->lances) -1]->getUsuario();
        return $lance->getUsuario() == $ultimoLance;
    }

    private function totalLancesPorUsuario($usuario)
    {
        return array_reduce(
            $this->lances,
            function (int $acumulado, Lance $lanceAtual) use ($usuario) {
                if($lanceAtual->getUsuario() == $usuario) {
                    return $acumulado + 1;
                }

                return $acumulado;
            },
            0
        );
    }
}
