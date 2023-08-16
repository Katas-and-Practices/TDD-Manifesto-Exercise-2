<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class NumberStringParser
{
    private array $validSeparators;
    private array $errorMessages = [];

    public function __construct(
        private string $numbersString,
        array $defaultSeparators = [',', "\n"],
    ) {
        $this->validSeparators = $defaultSeparators;
    }

    public function parse(): array
    {
        $customSeparator = $this->extractCustomSeparator();
        $this->removeCustomSeparatorSection($customSeparator);
        $this->validSeparators = is_null($customSeparator) ? $this->validSeparators : [$customSeparator];
        $numbers = $this->extractNumbers();
        $this->checkForErrors($numbers);

        return $numbers;
    }

    private function extractNumbers(): array
    {
        $numbers = [];
        $previousNumberStartingIndex = 0;
        $isPreviousIndexNumber = false;
        $separatorIndex = 0;
        $this->numbersStringLength = strlen($this->numbersString);

        for ($i = 0; $i < $this->numbersStringLength; $i++) {
            if (!preg_match('/[0-9\-]/', $this->numbersString[$i])) {
                if ($isPreviousIndexNumber) {
                    $numbers[] = $this->extractNumber($previousNumberStartingIndex, $i);

                    $matched = false;
                    for ($j = 0; $j < count($this->validSeparators); $j++) {
                        if ($this->numbersString[$i] === $this->validSeparators[$j][$separatorIndex]) {
                            $matched = true;
                        }
                    }
                    if (!$matched) {
                        $this->errorMessages[] = 'Expected "' . $this->validSeparators[0] . '" but "' . $this->numbersString[$i] . "\" found at position $i";
                    }
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
        $numbers[] = (int)substr($this->numbersString, $previousNumberStartingIndex);

        return $numbers;
    }

    private function extractNumber(int $previousIndex, int $i)
    {
        return (int) substr($this->numbersString, $previousIndex, $i - $previousIndex);
    }

    private function extractCustomSeparator(): string|null
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

    private function validateStringEnding(): void
    {
        $stringLength = strlen($this->numbersString);

        if ($stringLength > 0 && in_array($this->numbersString[$stringLength - 1], $this->validSeparators)) {
            $this->errorMessages[] = 'Cannot have separator at the end of string';
        }
    }

    private function validateNoNegativeNumbers(array $numbers): void
    {
        $negativeNumbersString = '';

        foreach ($numbers as $number) {
            if ($number < 0) {
                $negativeNumbersString .= (strlen($negativeNumbersString) ? ', ' : '') . $number;
            }
        }

        if (strlen($negativeNumbersString)) {
            array_unshift($this->errorMessages, 'Negative number(s) not allowed: ' . $negativeNumbersString);
        }
    }

    private function checkForErrors(array $numbers)
    {
        $this->validateStringEnding();
        $this->validateNoNegativeNumbers($numbers);

        if (count($this->errorMessages)) {
            throw new \Exception(implode("\n", $this->errorMessages));
        }
    }
}