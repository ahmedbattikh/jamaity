<?php

namespace App\Enum;

enum AssociationTypeEnum: string
{
    case ASSOCIATION = 'Association';
    case FILIALE_ASSOCIATION = 'Filiale d\'une association';
    case RESEAU_ASSOCIATIONS = 'Réseau d\'associations';

    /**
     * Get all association types as choices for forms
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
     * Get all association type values as a simple array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}