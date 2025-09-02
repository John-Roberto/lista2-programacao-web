<?php

declare(strict_types=1);

namespace Exercises;

/**
 * Classe Carro
 *
 * Um veículo tem:
 *  - consumo (km por litro) definido no construtor (float > 0)
 *  - nível de combustível no tanque (litros), inicial 0
 *
 * Métodos:
 *  - andar(float $distancia): float  -> retorna a distância efetivamente percorrida
 *  - getCombustivel(): float
 *  - setCombustivel(float $litros): void  -> adiciona combustível ao tanque
 */
final class Carro
{
    private float $consumo; // km por litro
    private float $tanque;  // litros

    public function __construct(float $consumo)
    {
        if ($consumo <= 0.0 || !is_finite($consumo)) {
            throw new \InvalidArgumentException('Consumo deve ser um número positivo.');
        }
        $this->consumo = $consumo;
        $this->tanque = 0.0;
    }

    /**
     * Simula dirigir o veículo por uma distância (km).
     * Reduz o nível de combustível proporcionalmente.
     * Retorna a distância efetivamente percorrida (pode ser menor se combustível insuficiente).
     */
    public function andar(float $distancia): float
    {
        if ($distancia < 0.0 || !is_finite($distancia)) {
            throw new \InvalidArgumentException('Distância inválida.');
        }

        $litrosNecessarios = $distancia / $this->consumo;

        if ($litrosNecessarios <= $this->tanque + 1e-12) {
            // combustível suficiente
            $this->tanque -= $litrosNecessarios;
            return $distancia;
        }

        // combustível insuficiente: percorre o máximo possível até acabar o tanque
        $distanciaPossivel = $this->tanque * $this->consumo;
        $this->tanque = 0.0;
        return $distanciaPossivel;
    }

    /**
     * Retorna o nível atual do tanque (litros)
     */
    public function getCombustivel(): float
    {
        return $this->tanque;
    }

    /**
     * Abastece o tanque adicionando litros (não há capacidade máxima definida)
     */
    public function setCombustivel(float $litros): void
    {
        if ($litros < 0.0 || !is_finite($litros)) {
            throw new \InvalidArgumentException('Quantidade de litros inválida.');
        }
        $this->tanque += $litros;
    }

    /**
     * Retorna o consumo (km por litro)
     */
    public function getConsumo(): float
    {
        return $this->consumo;
    }
}