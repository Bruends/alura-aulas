<?php

namespace Alura\Pdo\Domain\Model;

class Phone
{
    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    public function formattedNumber (): string
    {
        return "($this->areaCode) $this->number";
    }
}