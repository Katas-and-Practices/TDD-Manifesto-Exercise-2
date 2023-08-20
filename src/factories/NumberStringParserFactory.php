<?php

namespace ExerciseTwo\Factories;

require_once 'src/parsers/NumberStringParser.php';

use ExerciseTwo\Parsers\NumberStringParser;

interface NumberStringParserFactory
{
    public function create(): NumberStringParser;
}