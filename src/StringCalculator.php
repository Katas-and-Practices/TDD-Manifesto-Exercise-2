<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class StringCalculator
{
    private $validSeparators = [',', "\n"];

    public function add(string $inputNumbers): int
    {
        $this->validateStringEnding($inputNumbers);
        $customSeparator = $this->getCustomSeparator($inputNumbers);
        $numbers = $this->parseNumbersString($inputNumbers, $customSeparator);
        $result = $this->sum($numbers);

        return $result;
    }

    // TODO: Separate into another NumberStringParserClass ?
    private function parseNumbersString(string $numbersString, string|null $customSeparator): array
    {
        $numbers = [];
        $previousIndex = 0;
        $numbersStringLength = strlen($numbersString);
        $separators = is_null($customSeparator) ? $this->validSeparators : [$customSeparator];
        $errorMessages = [];

        for ($i = 0; $i < $numbersStringLength; $i++) {
            if (in_array($numbersString[$i], $separators)) {
                $numbers[] = (int)substr($numbersString, $previousIndex, $i + 1 - $previousIndex);
                $previousIndex = $i + 1;
            }
            elseif ($numbersString[$i] !== '-' && !is_numeric($numbersString[$i])) {
                for ($sepIndex = 0; $sepIndex < count($separators); $sepIndex++) {
                    $separatorMatch = true;
                    for ($k = 0, $q = $i; $k < strlen($separators[$sepIndex]) && $q < $numbersStringLength; $k++, $q++) {
                        if ($separators[$sepIndex][$k] !== $numbersString[$q]) {
                            $separatorMatch = false;
                            break;
                        }
                    }
                    if ($separatorMatch) {
                        break;
                    }
                }
                if ($separatorMatch) {
                    $numbers[] = (int)substr($numbersString, $previousIndex, $i - $previousIndex);
                    $i += strlen($separators[$sepIndex]) - 1;
                    $previousIndex = $i + 1;
                }
                elseif ($sepIndex === count($separators)) {
                    $message = is_null($customSeparator)
                        ? 'Expected one of "' . implode(' ', $separators)
                        : "Expected \"$customSeparator";

                    $invalidSeparator = '';
                    $restOfNumbersString = substr($numbersString, $i);
                    for ($j = 0; $j < strlen($restOfNumbersString); $j++) {
                        if (preg_match('/[0-9\-]/', $restOfNumbersString[$j])) {
                            $invalidSeparator = substr($restOfNumbersString, 0, $j);
                            break;
                        }
                    }
                    $errorMessages[] = $message . '" but "' . $invalidSeparator . '" found at position ' . $i;

                    $i += strlen($invalidSeparator) - 1;
                    $previousIndex = $i + 1;
                }
            }
        }
        $numbers[] = (int)substr($numbersString, $previousIndex);

        $negativeNumbersError = $this->validateNoNegativeNumbers($numbers);
        if ($negativeNumbersError) {
            array_unshift($errorMessages, $negativeNumbersError);
        }

        if (count($errorMessages)) {
            throw new \Exception(implode("\n", $errorMessages));
        }

        return $numbers;
    }

    private function sum(array $numbers)
    {
        return array_reduce($numbers, fn($carry, $number) => $carry + $number);
    }

    private function getCustomSeparator(&$inputNumbers): string|null
    {
        $START_INDEX_OF_CUSTOM_SEPARATOR = 2;
        $customSeparator = null;

        if (str_starts_with($inputNumbers, '//')) {
            $endIndexOfCustomSeparator = strpos($inputNumbers, "\n");
            $customSeparator = substr(
                $inputNumbers,
                $START_INDEX_OF_CUSTOM_SEPARATOR,
                $endIndexOfCustomSeparator - $START_INDEX_OF_CUSTOM_SEPARATOR
            );
            $inputNumbers = substr($inputNumbers, $endIndexOfCustomSeparator + 1);
        }

        return $customSeparator;
    }

    private function validateStringEnding(string $numbersString): void
    {
        $stringLength = strlen($numbersString);

        if ($stringLength > 0 && in_array($numbersString[$stringLength - 1], $this->validSeparators)) {
            throw new \Exception('Cannot have separator at the end of string');
        }
    }

    private function validateNoNegativeNumbers(array $numbers): string|null
    {
        $negativeNumbersString = '';

        foreach ($numbers as $number) {
            if ($number < 0) {
                $negativeNumbersString .= (strlen($negativeNumbersString) ? ', ' : '') . $number;
            }
        }

        if (strlen($negativeNumbersString)) {
            return 'Negative number(s) not allowed: ' . $negativeNumbersString;
        }

        return null;
    }
}
