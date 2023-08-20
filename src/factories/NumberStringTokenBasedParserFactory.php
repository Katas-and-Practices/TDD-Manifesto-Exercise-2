<?php

namespace ExerciseTwo\Factories;

require_once 'NumberStringParserFactory.php';
require_once 'src/NumberStringTokenBasedParser.php';

use ExerciseTwo\Parsers\NumberStringTokenBasedParser;

class NumberStringTokenBasedParserFactory implements NumberStringParserFactory
{
    public function create(): NumberStringTokenBasedParser
    {
        return new NumberStringTokenBasedParser();
    }
}