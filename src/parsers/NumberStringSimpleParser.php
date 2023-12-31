<?php

declare(strict_types = 1);

namespace ExerciseTwo\Parsers;

require_once 'NumberStringParser.php';

class NumberStringSimpleParser implements NumberStringParser
{
    private array $validSeparators;
    private array $errorMessages = [];
    private array $numbers = [];
    private string $numbersString;

    public function __construct(
        array $defaultSeparators = [',', "\n"]
    ) {
        $this->validSeparators = $defaultSeparators;
    }

    public function parse(string $numbersString): array
    {
        $this->numbersString = $numbersString;

        $customSeparator = $this->returnCustomSeparator();
        $this->removeCustomSeparatorSection($customSeparator);
        $this->validSeparators = is_null($customSeparator) ? $this->validSeparators : [$customSeparator];
        $this->extractNumbers();
        $this->throwErrors();

        return $this->numbers;
    }

    private function extractNumbers(): void
    {
        $previousNumberStartingIndex = 0;
        $isPreviousIndexNumber = false;
        $separatorIndex = 0;

        for ($i = 0; $i < strlen($this->numbersString); $i++) {
            if (!preg_match('/[0-9\-]/', $this->numbersString[$i])) {
                if ($isPreviousIndexNumber) {
                    $this->numbers[] = $this->extractNumber($previousNumberStartingIndex, $i);

                    $this->validateSeparatorByMatchingCharWithSeparators($i, $separatorIndex);
                }

                $separatorIndex++;
                $isPreviousIndexNumber = false;
            }
            else {
                $separatorIndex = 0;

                if (!$isPreviousIndexNumber) {
                    $previousNumberStartingIndex = $i;
                }
                $isPreviousIndexNumber = true;
            }
        }
        $this->numbers[] = $this->extractNumber($previousNumberStartingIndex, $i);
    }

    private function extractNumber(int $previousIndex, int $i)
    {
        return (int) substr($this->numbersString, $previousIndex, $i - $previousIndex);
    }

    private function validateSeparatorByMatchingCharWithSeparators(int $stringIndex, int $separatorIndex): void
    {
        $matched = false;
        for ($i = 0; $i < count($this->validSeparators); $i++) {
            if ($this->numbersString[$stringIndex] === $this->validSeparators[$i][$separatorIndex]) {
                $matched = true;
            }
        }
        if (!$matched) {
            $this->errorMessages[] = 'Expected "' . $this->validSeparators[0] . '" but "' . $this->numbersString[$stringIndex] . "\" found at position $stringIndex";
        }
    }

    private function returnCustomSeparator(): string|null
    {
        $START_INDEX_OF_CUSTOM_SEPARATOR = 2;
        $customSeparator = null;
        
        if (str_starts_with($this->numbersString, '//')) {
            $endIndexOfCustomSeparator = strpos($this->numbersString, "\n");
            $customSeparator = substr(
                $this->numbersString,
                $START_INDEX_OF_CUSTOM_SEPARATOR,
                $endIndexOfCustomSeparator - $START_INDEX_OF_CUSTOM_SEPARATOR
            );
        }
        
        return $customSeparator;
    }
    
    private function removeCustomSeparatorSection(string|null $customSeparator): void
    {
        if (!is_null($customSeparator)) {
            $endIndexOfCustomSeparator = strpos($this->numbersString, "\n");
            $this->numbersString = substr($this->numbersString, $endIndexOfCustomSeparator + 1);
        }
    }

    private function throwErrors()
    {
        $this->validateStringEnding();
        $this->validateNoNegativeNumbers();

        if (count($this->errorMessages)) {
            throw new \Exception(implode("\n", $this->errorMessages));
        }
    }

    private function validateStringEnding(): void
    {
        $stringLength = strlen($this->numbersString);

        if ($stringLength > 0 && in_array($this->numbersString[$stringLength - 1], $this->validSeparators)) {
            $this->errorMessages[] = 'Cannot have separator at the end of string';
        }
    }

    private function validateNoNegativeNumbers(): void
    {
        $negativeNumbersString = '';

        foreach ($this->numbers as $number) {
            if ($number < 0) {
                $negativeNumbersString .= (strlen($negativeNumbersString) ? ', ' : '') . $number;
            }
        }

        if (strlen($negativeNumbersString)) {
            array_unshift($this->errorMessages, 'Negative number(s) not allowed: ' . $negativeNumbersString);
        }
    }
}