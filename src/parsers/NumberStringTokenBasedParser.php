<?php

declare(strict_types = 1);

namespace ExerciseTwo\Parsers;

require_once 'NumberStringParser.php';

class NumberStringTokenBasedParser implements NumberStringParser
{
    public function parse(string $numbersString): array
    {
        throw new \Exception('Token based number string parser not implemented');
    }
}