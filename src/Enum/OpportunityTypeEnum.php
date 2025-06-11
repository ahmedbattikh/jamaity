<?php

namespace App\Enum;

enum OpportunityTypeEnum: string
{
    case OFFRE_EMPLOI = 'Offre d\'emploi';
    case APPEL_CONSULTANTS = 'Appel à consultants';
    case APPEL_DONS = 'Appel à dons';
    case APPEL_OFFRES = 'Appel d\'offres';
    case OFFRE_FORMATION = 'Offre de formation';
    case OFFRE_STAGE = 'Offre de stage';
    case APPEL_PROJETS = 'Appel à projets';
    case APPEL_VOLONTAIRES = 'Appel à volontaires';
    case APPEL_CANDIDATURE = 'Appel à candidature';
    case OPPORTUNITE_INTERNATIONAL = 'Opportunité à l\'international';

    /**
     * Get all opportunity types as choices for forms
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
     * Get all opportunity type values as a simple array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}