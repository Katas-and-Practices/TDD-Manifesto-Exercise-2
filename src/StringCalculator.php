<?php

declare(strict_types = 1);

namespace ExerciseTwo;

class StringCalculator
{
    private $validSeparators = [',', "\n"];

    public function add(string $inputNumbers): int
    {
        $this->validateString($inputNumbers);
        $customSeparator = $this->getCustomSeparator($inputNumbers);
        $numbers = $this->parseNumbersString($inputNumbers, $customSeparator);
        $result = $this->sum($numbers);

        return $result;
    }

    private function parseNumbersString(string $numbersString, string|null $customSeparator): array
    {
        $numbers = [];
        $previousIndex = 0;
        $stringLength = strlen($numbersString);
        $separators = is_null($customSeparator) ? $this->validSeparators : [$customSeparator];
        for ($i = 0; $i < $stringLength; $i++) {
            if (in_array($numbersString[$i], $separators)) {
                $numbers[] = (int)substr($numbersString, $previousIndex, $i + 1 - $previousIndex);
                $previousIndex = $i + 1;
            }
            elseif ($numbersString[$i] !== '-' && !is_numeric($numbersString[$i])) {
                for ($sepIndex = 0; $sepIndex < count($separators); $sepIndex++) {
                    $separatorMatch = true;
                    for ($k = 0, $q = $i; $k < strlen($separators[$sepIndex]) && $q < $stringLength; $k++, $q++) {
                        if ($separators[$sepIndex][$k] !== $numbersString[$q]) {
                            $separatorMatch = false;
                            break;
                        }
                    }
                    if ($separatorMatch) {
                        $numbers[] = (int)substr($numbersString, $previousIndex, $i - $previousIndex);
                        $i += strlen($separators[$sepIndex]) - 1;
                        $previousIndex = $i + 1;
                        break;
                    }
                    else {
                        $message = is_null($customSeparator)
                            ? 'Expected one of "' . implode(' ', $separators)
                            : "Expected \"$customSeparator";

                        $message .= '" but "' . $numbersString[$i] . '" found at position ' . $i;

                        throw new \Exception($message);
                    }
                }
            }
        }
        $numbers[] = (int)substr($numbersString, $previousIndex);

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

    private function validateString(string $numbersString): void
    {
        $stringLength = strlen($numbersString);

        if ($stringLength > 0 && in_array($numbersString[$stringLength - 1], $this->validSeparators)) {
            throw new \Exception('Cannot have separator at the end of string');
        }
    }
}
