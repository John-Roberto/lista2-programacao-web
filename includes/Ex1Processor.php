<?php
declare(strict_types=1);

namespace Exercises;

final class Ex1Processor
{
    public function sumStrings(string $a, string $b): string
    {
        return sprintf("A: %s | B: %s | resultado (concat): %s", $a, $b, $a . $b);
    }
}