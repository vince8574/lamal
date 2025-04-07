<?php

namespace App\Console\Commands;

use App\Models\AgeRange;
use App\Models\Canton;
use App\Models\Franchise;
use App\Models\Mediane;
use App\Models\Prime;
use App\Models\Tariftype;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Mediane extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mediane';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcule et enregistre la médiane des primes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        private function calculateMedianByCantons()
    {
        $this->info('Calcul des médianes par canton...');
        $cantons = Canton::all();
        
        $tableData = [];
        
        $progressBar = $this->output->createProgressBar($cantons->count());
        $progressBar->start();
        
        foreach ($cantons as $canton) {
            $query = Prime::where('canton_id', $canton->id)
                         ->where('year', $this->year);
            
            $count = $query->count();
            
            if ($count > 0) {
                $primes = $query->pluck('cost')->toArray();
                $median = $this->calculateMedian($primes);
                
                // Sauvegarder dans la base de données
                Mediane::create([
                    'canton_id' => $canton->id,
                    'median_value' => $median,
                    'count' => $count,
                    'type' => 'by_canton',
                    'year' => $this->year
                ]);
                
                $tableData[] = [
                    'canton' => $canton->name,
                    'code' => $canton->key,
                    'count' => $count,
                    'median' => $median,
                ];
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        $this->table(
            ['Canton', 'Code', 'Nombre', 'Médiane (CHF)'],
            $tableData
        );
    }

    /**
     * Calcule et enregistre la médiane des primes avec tous les filtres combinés
     */
    private function calculateMedianByFilters()
    {
        $this->info('Calcul des médianes avec filtres...');
        
        // Obtenir tous les filtres possibles
        $ageRanges = AgeRange::all();
        $franchises = Franchise::all();
        $tarifTypes = Tariftype::all();
        $cantons = Canton::all();
        $accidentOptions = [true, false];
        
        $results = [];
        $combinaisons = $ageRanges->count() * $franchises->count() * $tarifTypes->count() * $cantons->count() * 2;
        
        $this->info("Analyse de $combinaisons combinaisons possibles...");
        $progressBar = $this->output->createProgressBar($combinaisons);
        $progressBar->start();
        
        $saved = 0;
        
        // Pour chaque combinaison de filtres
        foreach ($ageRanges as $ageRange) {
            foreach ($franchises as $franchise) {
                foreach ($tarifTypes as $tarifType) {
                    foreach ($cantons as $canton) {
                        foreach ($accidentOptions as $accident) {
                            $query = Prime::query()
                                ->where('age_range_id', $ageRange->id)
                                ->where('franchise_id', $franchise->id)
                                ->where('tariftype_id', $tarifType->id)
                                ->where('canton_id', $canton->id)
                                ->where('accident', $accident)
                                ->where('year', $this->year);
                            
                            $count = $query->count();
                            
                            // Ne calculer la médiane que s'il y a des données
                            if ($count > 0) {
                                $primes = $query->pluck('cost')->toArray();
                                $median = $this->calculateMedian($primes);
                                
                                // Sauvegarder dans la base de données
                                Mediane::create([
                                    'age_range_id' => $ageRange->id,
                                    'franchise_id' => $franchise->id,
                                    'tariftype_id' => $tarifType->id,
                                    'canton_id' => $canton->id,
                                    'accident' => $accident,
                                    'count' => $count,
                                    'median_value' => $median,
                                    'type' => 'by_filters',
                                    'year' => $this->year
                                ]);
                                
                                $saved++;
                                
                                // Limiter le nombre de résultats affichés pour éviter de surcharger la console
                                if (count($results) < 20) {
                                    $results[] = [
                                        'age_range' => $ageRange->label,
                                        'franchise' => $franchise->numerique,
                                        'tarif_type' => $tarifType->label,
                                        'canton' => $canton->key,
                                        'accident' => $accident ? 'Avec' : 'Sans',
                                        'count' => $count,
                                        'median' => $median,
                                    ];
                                }
                            }
                            
                            $progressBar->advance();
                        }
                    }
                }
            }
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        $this->info("$saved médianes avec filtres enregistrées dans la base de données.");
        
        // Afficher un échantillon des résultats
        if (!empty($results)) {
            $this->info("Exemple des résultats (limité à " . count($results) . " lignes):");
            $this->table(
                ['Tranche d\'âge', 'Franchise', 'Type de tarif', 'Canton', 'Accident', 'Nombre', 'Médiane (CHF)'],
                $results
            );
        }
    }

    /**
     * Calcule la médiane d'un tableau de valeurs
     * 
     * @param array $values Tableau de valeurs
     * @return float Médiane
     */
    private function calculateMedian(array $values): float
    {
        if (empty($values)) {
            return 0;
        }
        
        $count = count($values);
        sort($values);
        
        $middle = floor($count / 2);
        
        if ($count % 2 === 0) {
            // Si le nombre d'éléments est pair, prendre la moyenne des deux valeurs centrales
            return ($values[$middle - 1] + $values[$middle]) / 2;
        } else {
            // Si le nombre d'éléments est impair, prendre la valeur centrale
            return $values[$middle];
        }
    }
}
