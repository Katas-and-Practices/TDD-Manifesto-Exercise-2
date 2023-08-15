<?php

declare(strict_types = 1);

namespace ExerciseTwo\Tests\Unit;

require 'src/StringCalculator.php';

use ExerciseTwo\StringCalculator;
use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{
    public function testShouldReturnZeroGivenEmptyString(): void
    {
        $calculator = new StringCalculator();

        $result = $calculator->add('');

        $this->assertSame(0, $result);
    }

    public function testShouldReturnNumberGivenOneNumber(): void
    {
        $calculator = new StringCalculator();

        $result = $calculator->add('14');

        $this->assertSame(14, $result);
    }

    public function testShouldReturnSumGivenTwoNumbers(): void
    {
        $calculator = new StringCalculator();

        $result = $calculator->add('130,25');

        $this->assertSame(155, $result);
    }
}