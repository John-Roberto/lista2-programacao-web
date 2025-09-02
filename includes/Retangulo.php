<?php

declare(strict_types=1);

/**
 * Classe Retangulo
 *
 * Atributos: largura e altura (float)
 * Construtor: valores padrão 1.0
 * Métodos: getters/setters, area(), perimetro(), ehQuadrado()
 */
final class Retangulo
{
    private float $largura;
    private float $altura;

    public function __construct(float $largura = 1.0, float $altura = 1.0)
    {
        $this->setLargura($largura);
        $this->setAltura($altura);
    }

    public function getLargura(): float
    {
        return $this->largura;
    }

    public function getAltura(): float
    {
        return $this->altura;
    }

    public function setLargura(float $largura): void
    {
        if ($largura <= 0.0) {
            throw new InvalidArgumentException('Largura deve ser maior que zero.');
        }
        $this->largura = $largura;
    }

    public function setAltura(float $altura): void
    {
        if ($altura <= 0.0) {
            throw new InvalidArgumentException('Altura deve ser maior que zero.');
        }
        $this->altura = $altura;
    }

    public function area(): float
    {
        return $this->largura * $this->altura;
    }

    public function perimetro(): float
    {
        return 2.0 * ($this->largura + $this->altura);
    }

    public function ehQuadrado(): bool
    {
        // Usa tolerância para evitar problemas de comparação com floats
        return abs($this->largura - $this->altura) < 1e-9;
    }
}
