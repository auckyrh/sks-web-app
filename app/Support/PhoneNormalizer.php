<?php

namespace App\Support;

class PhoneNormalizer
{
    /**
     * Normalize a WhatsApp / phone number to canonical digits-only format.
     *
     * - Strips spaces, dashes, plus signs, parentheses, and any non-digit character.
     * - Converts a leading 0 to 62 (Indonesian local format → E.164 without the +).
     * - Leaves other country codes (non-0, non-62 prefix) unchanged.
     *
     * Examples:
     *   "0812 345 6789"      → "628123456789"
     *   "+62 812-3456-789"   → "628123456789"
     *   "628123456789"       → "628123456789"
     *   "+65 8123 4567"      → "6581234567"
     */
    public static function normalize(string $phone): string
    {
        // Strip everything that is not a digit
        $digits = preg_replace('/\D/', '', $phone);

        // Convert leading 0 → 62
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }
}
