<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class StringCalculator
{
    public function add(string $numbers): int
    {
        $numbers = explode(',', $numbers);
        $result = 0;

        foreach ($numbers as $number) {
            $result += (int)$number;
        }

        return $result;
    }
}
