<?php

namespace App\Enum;

enum ExpertiseEnum: string
{
    case RH = 'RH';
    case COMMUNICATION = 'Communication';
    case FINANCE = 'Finance';
    case MANAGEMENT = 'Management';
    case CONSULTING = 'Consulting';
    case ADMINISTRATION = 'Administration';

    /**
     * Get all expertise domains as choices for forms
     */
    public static function getChoices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->value] = $case->value;
        }
        return $choices;
    }

    /**
     * Get all expertise domain values as a simple array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}