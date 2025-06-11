<?php

namespace App\Enum;

enum RegionEnum: string
{
    case ARIANA = 'Ariana';
    case BEJA = 'Béja';
    case BEN_AROUS = 'Ben Arous';
    case BIZERTE = 'Bizerte';
    case GABES = 'Gabès';
    case GAFSA = 'Gafsa';
    case JENDOUBA = 'Jendouba';
    case KAIROUAN = 'Kairouan';
    case KASSERINE = 'Kasserine';
    case KEBILI = 'Kébili';
    case KEF = 'Le Kef';
    case MAHDIA = 'Mahdia';
    case MANOUBA = 'Manouba';
    case MEDENINE = 'Médenine';
    case MONASTIR = 'Monastir';
    case NABEUL = 'Nabeul';
    case SFAX = 'Sfax';
    case SIDI_BOUZID = 'Sidi Bouzid';
    case SILIANA = 'Siliana';
    case SOUSSE = 'Sousse';
    case TATAOUINE = 'Tataouine';
    case TOZEUR = 'Tozeur';
    case TUNIS = 'Tunis';
    case ZAGHOUAN = 'Zaghouan';

    /**
     * Get all region values as an array
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
     * Get all region values as a simple array
     */
    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}