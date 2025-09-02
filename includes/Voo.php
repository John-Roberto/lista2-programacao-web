<?php

declare(strict_types=1);

namespace Exercises;

require_once __DIR__ . '/Data.php';

use Exercises\Data;

/**
 * Classe Voo
 *
 * Cada voo:
 * - número do voo (int)
 * - data (objeto Data)
 * - máximo 100 assentos
 *
 * Métodos:
 * - __construct(int $numero, Data $data)
 * - getProximoAssento(): int|null
 * - verificaAssento(int $num): bool
 * - ocupa(int $num): bool
 * - getVagas(): int
 * - getVoo(): int
 * - getDataVoo(): Data
 */
final class Voo
{
    private int $numero;
    private Data $data;
    private array $assentos; // true = ocupado, false = livre

    private const MAX_ASSENTOS = 100;

    public function __construct(int $numero, Data $data)
    {
        if ($numero <= 0) {
            throw new \InvalidArgumentException('Número do voo deve ser positivo.');
        }
        $this->numero = $numero;
        $this->data = $data;
        $this->assentos = array_fill(1, self::MAX_ASSENTOS, false);
    }

    public function getProximoAssento(): ?int
    {
        foreach ($this->assentos as $num => $ocupado) {
            if (!$ocupado) return $num;
        }
        return null;
    }

    public function verificaAssento(int $num): bool
    {
        if ($num < 1 || $num > self::MAX_ASSENTOS) {
            throw new \InvalidArgumentException('Número de assento inválido.');
        }
        return $this->assentos[$num];
    }

    public function ocupa(int $num): bool
    {
        if ($num < 1 || $num > self::MAX_ASSENTOS) {
            throw new \InvalidArgumentException('Número de assento inválido.');
        }
        if ($this->assentos[$num]) {
            return false; // já ocupado
        }
        $this->assentos[$num] = true;
        return true;
    }

    public function getVagas(): int
    {
        return count(array_filter($this->assentos, fn($v) => !$v));
    }

    public function getVoo(): int
    {
        return $this->numero;
    }

    public function getDataVoo(): Data
    {
        return $this->data;
    }
}