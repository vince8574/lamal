<?php

namespace App\Traits;

class CalculDiff
{
    /**
     * Calcule la différence en pourcentage entre le coût d'une prime et sa valeur médiane
     * 
     * @param \App\Models\Prime $prime
     * @return array|null
     */
    public static function calculateMedianDifference($prime)
    {
        // Récupérer la valeur médiane correspondante
        $mediane = \App\Models\Mediane::where('canton_id', $prime->canton_id)
            ->where('age_range_id', $prime->age_range_id)
            ->where('franchise_id', $prime->franchise_id)
            ->where('tariftype_id', $prime->tariftype_id)
            ->where('accident', $prime->accident)
            ->first();

        if (!$mediane) {
            return null;
        }

        $difference = $prime->cost - $mediane->median_value;
        $percentage = ($difference / $mediane->median_value) * 100;
        $formattedPercentage = number_format(abs($percentage), 1);
        $color = $difference > 0 ? 'text-red-500' : 'text-green-500';
        $sign = $difference > 0 ? '+' : '-';

        return [
            'percentage' => $formattedPercentage,
            'color' => $color,
            'sign' => $sign,
            'raw_percentage' => $percentage
        ];
    }
}
