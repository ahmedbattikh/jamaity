<?php

namespace App\Enum;

enum ResourceTypeEnum: string
{
    case REFERENCES_LEGALES = 'Références légales';
    case FICHES_PRATIQUES = 'Fiches pratiques';
    case GUIDES_ASSOCIATIFS = 'Guides associatifs';
    case ETUDES_RAPPORTS = 'Etudes & Rapports';
    case MODELES_DOCUMENTS = 'Modèles de documents';
    case CAPSULES_PEDAGOGIQUES = 'Capsules pédagogiques';
    case POLICY_PAPERS = 'Policy papers';

    /**
     * Get all resource types as choices for forms
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
     * Get all resource type values as a simple array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}