<?php

declare(strict_types=1);

namespace Exercises;

/**
 * Classe Calculadora
 *
 * Res: real  -> armazena o resultado atual
 * Mem: real  -> armazena o resultado anterior (última operação)
 *
 * Operações suportadas:
 *  - zerar()
 *  - desfaz()
 *  - getRes(): float
 *  - soma(valor: float)
 *  - subtrai(valor: float)
 *  - multiplica(valor: float)
 *  - divide(valor: float)
 *  - potencia(exp: int)
 *  - porcentagem(porc: float)   -> aplica (Res * (porc / 100))
 *  - raiz()
 */
final class Calculadora
{
    private float $res;
    private float $mem;

    public function __construct()
    {
        $this->res = 0.0;
        $this->mem = 0.0;
    }

    public function zerar(): void
    {
        $this->mem = $this->res;
        $this->res = 0.0;
    }

    public function desfaz(): float
    {
        $this->res = $this->mem;
        $this->mem = 0.0;
        return $this->res;
    }

    public function getRes(): float
    {
        return $this->res;
    }

    public function soma(float $valor): float
    {
        $this->mem = $this->res;
        $this->res += $valor;
        return $this->res;
    }

    public function subtrai(float $valor): float
    {
        $this->mem = $this->res;
        $this->res -= $valor;
        return $this->res;
    }

    public function multiplica(float $valor): float
    {
        $this->mem = $this->res;
        $this->res *= $valor;
        return $this->res;
    }

    public function divide(float $valor): float
    {
        if ($valor == 0.0) {
            throw new \DivisionByZeroError('Divisão por zero não é permitida.');
        }
        $this->mem = $this->res;
        $this->res /= $valor;
        return $this->res;
    }

    public function potencia(int $exp): float
    {
        $this->mem = $this->res;
        $this->res = \pow($this->res, $exp);
        return $this->res;
    }

    public function porcentagem(float $porc): float
    {
        $this->mem = $this->res;
        $this->res = $this->res * ($porc / 100.0);
        return $this->res;
    }

    public function raiz(): float
    {
        if ($this->res < 0.0) {
            throw new \InvalidArgumentException('Raiz quadrada de número negativo não suportada.');
        }
        $this->mem = $this->res;
        $this->res = \sqrt($this->res);
        return $this->res;
    }

    public function getMem(): float
    {
        return $this->mem;
    }
}