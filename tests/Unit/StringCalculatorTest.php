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

    public function testShouldReturnSumGivenThreeNumbers(): void
    {
        $result = $this->calculator->add('33,98,72');

        $this->assertSame(203, $result);
    }

    public function testShouldReturnSumGivenSevenNumbers(): void
    {
        $result = $this->calculator->add('245,-5,0,233,60,003,77');

        $this->assertSame(613 , $result);
    }

    public function testShouldAcceptNewlineAsSeparator(): void
    {
        $result = $this->calculator->add("20\n30,50");

        $this->assertSame(100, $result);
    }
}