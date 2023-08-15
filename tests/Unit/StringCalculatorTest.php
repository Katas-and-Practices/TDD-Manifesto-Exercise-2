<?php

declare(strict_types = 1);

namespace ExerciseTwo\Tests\Unit;

require 'src/StringCalculator.php';

use ExerciseTwo\StringCalculator;
use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{
    protected StringCalculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new StringCalculator();
    }

    public function testShouldReturnZeroGivenEmptyString(): void
    {
        $result = $this->calculator->add('');

        $this->assertSame(0, $result);
    }

    public function testShouldReturnNumberGivenOneNumber(): void
    {
        $result = $this->calculator->add('14');

        $this->assertSame(14, $result);
    }

    public function testShouldReturnSumGivenTwoNumbers(): void
    {
        $result = $this->calculator->add('130,25');

        $this->assertSame(155, $result);
    }
}