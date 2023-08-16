<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class StringCalculator
{
    private $validSeparators = [',', "\n"];

    public function add(string $inputNumbers): int
    {
        $numbers = $this->parseNumbersString($inputNumbers);
        $result = $this->sum($numbers);

        return $result;
    }

    private function parseNumbersString(string $numbersString): array
    {
        $stringLength = strlen($numbersString);

        if ($stringLength > 0 && in_array($numbersString[$stringLength - 1], $this->validSeparators)) {
            throw new \Exception('Cannot have separator at the end of string');
        }
        $numbers = [];
        $previousIndex = 0;

        for ($i = 0; $i < $stringLength; $i++) {
            if (in_array($numbersString[$i], $this->validSeparators)) {
                $numbers[] = (int)substr($numbersString, $previousIndex, $i + 1 - $previousIndex);
                $previousIndex = $i + 1;
            }
        }
        $numbers[] = (int)substr($numbersString, $previousIndex);

        return $numbers;
    }

    private function sum(array $numbers)
    {
        return array_reduce($numbers, fn($carry, $number) => $carry + $number);
    }
}
