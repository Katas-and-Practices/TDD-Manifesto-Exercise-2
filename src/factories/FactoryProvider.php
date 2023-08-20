<?php

namespace ExerciseTwo\Factories;

require_once 'NumberStringSimpleParserFactory.php';
require_once 'NumberStringParserFactory.php';

class FactoryProvider
{
    private function __construct() {}

    public static function getNumberStringParserFactory(): NumberStringParserFactory
    {
        return new NumberStringSimpleParserFactory();
    }
}