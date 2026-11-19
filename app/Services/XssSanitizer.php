<?php

namespace App\Services;

class XssSanitizer
{
    /**
     * Trim and strip tags, then encode special characters to prevent stored XSS.
     */
    public static function clean(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $value = trim($value);
        $value = strip_tags($value);

        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    }

    /**
     * Recursively clean an associative array of strings.
     */
    public static function cleanArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = self::clean($value);
            }
        }

        return $data;
    }
}
