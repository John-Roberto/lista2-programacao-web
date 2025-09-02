<?php

declare(strict_types=1);

namespace Exercises;

use DateTime;
use DateInterval;
use Exception;

/**
 * Classe Data
 *
 * - Atributos: dia, mes, ano (int)
 * - Dois construtores: um com zeros (default), outro com parâmetros
 * - Métodos gets/sets para cada atributo
 * - incrementarDia(): avança para o próximo dia
 * - decrementarDia(): retrocede um dia
 * - __toString(): retorna dd/mm/aaaa
 * - isBissexto(): bool
 * - diferenca(Data $outra): int (diferença em dias)
 * - comparar(Data $outra): int (0, 1, -1)
 */
final class Data
{
    private int $dia;
    private int $mes;
    private int $ano;

    public function __construct(int $dia = 0, int $mes = 0, int $ano = 0)
    {
        $this->dia = $dia;
        $this->mes = $mes;
        $this->ano = $ano;
    }

    public function getDia(): int
    {
        return $this->dia;
    }
    public function getMes(): int
    {
        return $this->mes;
    }
    public function getAno(): int
    {
        return $this->ano;
    }

    public function setDia(int $dia): void
    {
        $this->dia = $dia;
    }
    public function setMes(int $mes): void
    {
        $this->mes = $mes;
    }
    public function setAno(int $ano): void
    {
        $this->ano = $ano;
    }

    private function toDateTime(): DateTime
    {
        return new DateTime(sprintf('%04d-%02d-%02d', $this->ano, $this->mes, $this->dia));
    }

    public function incrementarDia(): void
    {
        $dt = $this->toDateTime();
        $dt->add(new DateInterval('P1D'));
        $this->atualizarDeDateTime($dt);
    }

    public function decrementarDia(): void
    {
        $dt = $this->toDateTime();
        $dt->sub(new DateInterval('P1D'));
        $this->atualizarDeDateTime($dt);
    }

    private function atualizarDeDateTime(DateTime $dt): void
    {
        $this->ano = (int)$dt->format('Y');
        $this->mes = (int)$dt->format('m');
        $this->dia = (int)$dt->format('d');
    }

    public function __toString(): string
    {
        return sprintf('%02d/%02d/%04d', $this->dia, $this->mes, $this->ano);
    }

    public function isBissexto(): bool
    {
        $ano = $this->ano;
        return ($ano % 400 === 0) || ($ano % 4 === 0 && $ano % 100 !== 0);
    }

    public function diferenca(Data $outra): int
    {
        $d1 = $this->toDateTime();
        $d2 = $outra->toDateTime();
        return (int)$d1->diff($d2)->format('%r%a'); // dias com sinal
    }

    public function comparar(Data $outra): int
    {
        $d1 = $this->toDateTime();
        $d2 = $outra->toDateTime();

        if ($d1 == $d2) return 0;
        return ($d1 > $d2) ? 1 : -1;
    }
}