<?php

namespace ExerciseTwo\Parsers;

interface NumberStringParser
{
    public function parse(string $s): array;
}