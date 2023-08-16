<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class StringCalculator
{
    public function add(string $inputNumbers): int
    {
        $result = 0;
        $previousIndex = 0;

        for ($i = 0; $i < strlen($inputNumbers); $i++) {
            if ($inputNumbers[$i] === ',' || $inputNumbers[$i] === "\n") {
                $result += (int)substr($inputNumbers, $previousIndex, $i + 1 - $previousIndex);
                $previousIndex = $i + 1;
            }
        }
        $result += (int)substr($inputNumbers, $previousIndex);

        return $result;
    }
}
