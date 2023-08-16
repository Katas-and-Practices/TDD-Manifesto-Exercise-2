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
        $result = $this->calculator->add('245,5,0,233,60,003,77');

        $this->assertSame(623 , $result);
    }

    public function testShouldAcceptNewlineAsSeparator(): void
    {
        $result = $this->calculator->add("20\n30,50");

        $this->assertSame(100, $result);
    }

    public function testShouldThrowErrorGivenSingleComma(): void
    {
        $this->expectException(\Exception::class);

        $this->calculator->add(',');
    }

    public function testShouldThrowErrorGivenSingleNewline(): void
    {
        $this->expectException(\Exception::class);

        $this->calculator->add("\n");
    }

    public function testShouldThrowErrorGivenCommaAtTheEnd(): void
    {
        $this->expectException(\Exception::class);

        $this->calculator->add("45,23\n100,");
    }

    public function testShouldThrowErrorGivenNewlineAtTheEnd(): void
    {
        $this->expectException(\Exception::class);

        $this->calculator->add("325\n3,100\n");
    }

    public function testShouldSumTwoNumbersGivenSingleLengthCustomSeparator(): void
    {
        $result = $this->calculator->add("//|\n42|35");

        $this->assertSame(77, $result);
    }

    public function testShouldSumTwoNumbersGivenMultiLengthCustomSeparator(): void
    {
        $result = $this->calculator->add("//sep\n197sep5");

        $this->assertSame(202, $result);
    }

    public function testShouldSumMultipleNumbersGivenMultiLengthCustomSeparator(): void
    {
        $result = $this->calculator->add("//my\n19my425my6my9028my33");

        $this->assertSame(9511, $result);
    }

    public function testShouldThrowExceptionWithMessageGivenWrongUsageOfSeparatorWithCustomSeparator(): void
    {
        $this->expectExceptionMessage('Expected ";" but "," found at position 6');

        $this->calculator->add("//;\n4;23;9,12");
    }

    public function testShouldThrowExceptionWithMessageGivenNegativeNumbers(): void
    {
        $this->expectExceptionMessage('Negative number(s) not allowed: -3, -50');

        $this->calculator->add("12\n-3\n99\n-50");
    }

    public function testShouldThrowExceptionWithAllMessagesGivenNegativeNumbersAndInvalidSeparator(): void
    {
        $this->expectExceptionMessage("Negative number(s) not allowed: -10, -66, -3\nExpected \"|\" but \";\" found at position 10");

        $this->calculator->add("//|\n15|-10|235;-66|-3");
    }
}