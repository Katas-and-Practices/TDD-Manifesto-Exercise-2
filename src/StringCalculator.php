<?php

declare(strict_types = 1);

namespace ExerciseTwo;

require_once 'factories/FactoryProvider.php';
require_once 'parsers/NumberStringParser.php';

use ExerciseTwo\Factories\FactoryProvider;
use ExerciseTwo\Parsers\NumberStringParser;

class StringCalculator
{
    private NumberStringParser $numberStringParser;

    public function __construct(NumberStringParser $parser = null)
    {
        if (is_null($parser)) {
            $factory = FactoryProvider::getNumberStringParserFactory();
            $parser = $factory->create();
        }

        $this->numberStringParser = $parser;
    }

    public function add(string $inputNumbers): int
    {
        $numbers = $this->numberStringParser->parse($inputNumbers);
        $result = $this->sum($numbers);

        return $result;
    }

    private function sum(array $numbers)
    {
        return array_reduce($numbers, fn($carry, $number) => $carry + $number);
    }
}
