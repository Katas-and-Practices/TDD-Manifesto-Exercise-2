<?php

declare(strict_types = 1);

namespace ExerciseTwo;

require_once 'parsers/NumberStringParser.php';

use ExerciseTwo\Parsers\NumberStringParser;

class StringCalculator
{
    public function __construct(private NumberStringParser $numberStringParser) {}

    public function add(string $inputNumbers): int
    {
        $numbers = $this->numberStringParser->parse($inputNumbers);
        $result = $this->sum($numbers);

        return $result;
    }

    private function sum(array $numbers)
    {
        return array_reduce($numbers, fn($carry, $number) => $carry + ($number > 999 ? 0 : $number));
    }
}
