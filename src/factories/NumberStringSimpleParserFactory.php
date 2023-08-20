<?php

namespace ExerciseTwo\Factories;

require_once 'NumberStringParserFactory.php';
require_once 'src/parsers/NumberStringSimpleParser.php';

use ExerciseTwo\Parsers\NumberStringSimpleParser;

class NumberStringSimpleParserFactory implements NumberStringParserFactory
{
    public function create(): NumberStringSimpleParser
    {
        return new NumberStringSimpleParser();
    }
}