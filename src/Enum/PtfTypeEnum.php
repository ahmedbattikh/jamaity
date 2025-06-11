<?php

namespace App\Enum;

enum PtfTypeEnum: string
{
    case ONG_INTERNATIONALES = 'Les ONG internationales';
    case AMBASSADES = 'Les ambassades';
    case COOPERATIONS_INTERNATIONALES = 'Les coopérations internationales';
    case FONDATIONS_INTERNATIONALES = 'Les Fondations Internationales';
    case PROGRAMMES = 'Les Programmes';
    case INSTITUTIONS_FINANCIERES = 'Les Institutions financières';
    case INSTITUTIONS_PUBLIQUES = 'Les Institutions publiques';
    case APPEL_CANDIDATURE = 'Appel à candidature';
    case CANDIDATURE_LIBRE = 'candidature libre';
    case PARTENAIRE_TECHNIQUE = 'Partenaire technique';

    /**
     * Get all PTF types as choices for forms
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
     * Get all PTF type values as a simple array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}