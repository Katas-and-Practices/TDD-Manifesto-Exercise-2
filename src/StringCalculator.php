<?php

declare(strict_types = 1);

namespace ExerciseTwo;

require 'NumberStringParser.php';

class StringCalculator
{
    public function add(string $inputNumbers): int
    {
        $numbers = (new NumberStringParser($inputNumbers))->parse();
        $result = $this->sum($numbers);

        return $result;
    }

    private function sum(array $numbers)
    {
        return array_reduce($numbers, fn($carry, $number) => $carry + $number);
    }
}
