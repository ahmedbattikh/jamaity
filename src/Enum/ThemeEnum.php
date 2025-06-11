<?php

namespace App\Enum;

enum ThemeEnum: string
{
    case PROTECTION_PATRIMOINE = 'Protection/Promotion du patrimoine';
    case AGRICULTURE = 'Agriculture';
    case ART_CULTURE = 'Art/Culture';
    case ARTISANAT = 'Artisanat';
    case ASSOCIATIONS_PROFESSIONNELS = 'Associations de professionnels';
    case HUMANITAIRE = 'Humanitaire';
    case CITOYENNETE_GOUVERNANCE = 'Citoyenneté et Gouvernance';
    case CITOYENNETE = 'Citoyenneté';
    case DECENTRALISATION = 'Décentralisation';
    case GOUVERNANCE = 'Gouvernance';
    case DEVELOPPEMENT_ECONOMIQUE_SOCIAL = 'Développement Economique et social';
    case ECONOMIE_SOCIALE_SOLIDAIRE = 'Economie Sociale et Solidaire';
    case DEVELOPPEMENT_LOCAL = 'Développement local';
    case INSERTION_SOCIALE = 'Insertion Sociale';
    case DROITS_HUMAINS = 'Droits Humains';
    case LOISIRS_SPORTS = 'Loisirs et Sports';
    case EMPLOI_FORMATION = 'Emploi et Formation';
    case EMPLOI = 'Emploi';
    case ENTREPRENEURIAT = 'Entrepreneuriat';
    case FORMATION = 'Formation';
    case EDUCATION = 'Education';
    case ECHANGE_CULTUREL = 'Échange Culturel';
    case SECURITE = 'Sécurité';
    case JEUNESSE = 'Jeunesse';
    case ENVIRONNEMENT = 'Environnement';
    case SANTE = 'Santé';
    case SCIENCES_TECHNOLOGIES = 'Sciences et technologies';
    case TOURISME = 'Tourisme';

    /**
     * Get all theme values as an array
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
     * Get all theme values as a simple array
     */
    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}