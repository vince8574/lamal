<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Trait\Csv;
use App\Models\AgeRange;
use App\Models\Canton;
use App\Models\Franchise;
use App\Models\Insurer;
use App\Models\Prime;
use App\Models\Tariftype;

class ImportPrimes extends Command
{
    use Csv;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-primes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $path = base_path('database/data/primes_2024.csv');
        $headers =  [
            "insurer_code",
            "canton",
            "country",
            "year",
            "year_2",
            "region_code",
            "age_range",
            "accident",
            "tarif",
            "tarif_type",
            "age_subrange",
            "franchise_class",
            "franchise",
            "cost",
            "basep",
            "basef",
            "tarif_name"
        ];

        //    

        $this->parse($path, $headers, function ($row) {
            $insurer = Insurer::where('bag_number', $row['insurer_code'])->first();

            if (!$insurer) {
                throw new \Exception("Insurer not found for code: " . $row['insurer_code']);
                // throw new \Exception("something gone wrong");
            }

            $age_label = match ($row['age_range']) {
                'AKL-KIN' => '0 - 17 ans',
                'AKL-JUG' => '18 - 25 ans',
                'AKL-ERW' => '26 ans et +',
                default => 'inconnu'
            };

            $age_range = AgeRange::firstOrCreate([
                'key' => $row['age_range']
            ], [
                'key' => $row['age_range'],
                'label' => $age_label
            ]);

            // $franchise_numerique = intval(str_replace('FRA-', '', $row['franchise']));
            $franchise = Franchise::firstOrCreate([
                'key' => $row['franchise']
            ], [
                'key' => $row['franchise'],
                'label' => $row['franchise'],
                'numerique' => intval(str_replace('FRA-', '', $row['franchise']))
            ]);

            $tarif_label = match ($row['tarif_type']) {
                'TAR-BASE' => 'Assurance de base',
                'TAR-DIV' => 'AUTRE MODELE',
                'TAR-HMO' => 'RESEAU DE SOINS',
                'TAR-HAM' => 'MEDECIN DE FAMILLE',
                default => 'inconnu'
            };
            /*
            $tarif_map = [
                'TAR-BASE' => 'Assurance de base',
                'TAR-DIV' => 'AUTRE MODELE',
                'TAR-HMO' => 'RESEAU DE SOINS',
                'TAR-HAM' => 'MEDECIN DE FAMILLE',
            ];

            $tarif_label = $tarif_map[$row['tarif_type']] ?? 'inconnu';

            $tarif_label = null;

            switch ($row['tarif_type']) {
                case 'TAR-BASE':
                    $tarif_label = 'Assurance de base';
                    break;
                default:
                    $tarif_label = 'inconnu';
            }*/

            $tarif_type = Tariftype::firstOrCreate([
                'key' => $row['tarif_type']
            ], [
                'key' => $row['tarif_type'],
                'code' => str_replace('TAR-', '', $row['tarif_type']),
                'label' => $tarif_label

                /*str_replace(
                    'TAR-BASE',
                    'ASSURANCE DE BASE',
                    str_replace(
                        'TAR-DIV',
                        'AUTRE MODELE',
                        str_replace(
                            'TAR-HMO',
                            'RESEAU DE SOINS',
                            str_replace('TAR-HAM', 'MEDECIN DE FAMILLE', $row['tarif_type'])
                        )
                    )
                )*/
            ]);
            $canton_name = match ($row['canton']) {
                'AG' => 'Argovie',
                'AI' => 'Appenzell Rhodes-Intérieures',
                'AR' => 'Appenzell Rhodes-Extérieures',
                'BE' => 'Berne',
                'BL' => 'Bâle-Campagne',
                'BS' => 'Bâle-Ville',
                'FR' => 'Fribourg',
                'GE' => 'Genève',
                'GL' => 'Glaris',
                'GR' => 'Grisons',
                'JU' => 'Jura',
                'LU' => 'Lucerne',
                'NE' => 'Neuchâtel',
                'NW' => 'Nidwald',
                'OW' => 'Obwald',
                'SG' => 'Saint-Gall',
                'SH' => 'Schaffhouse',
                'SO' => 'Soleure',
                'SZ' => 'Schwitz',
                'TG' => 'Thurgovie',
                'TI' => 'Tessin',
                'UR' => 'Uri',
                'VD' => 'Vaud',
                'VS' => 'Valais',
                'ZH' => 'Zurich',
                'ZG' => 'Zoug',
                default => 'inconnu'
            };
            $canton = Canton::firstOrCreate([
                'key' => $row['canton']
            ], [
                'key' => $row['canton'],
                'name' => $canton_name
            ]);
            $row['accident'] = $row['accident'] == "MIT-UNF";
            $prime = new Prime($row);
            $prime->insurer()->associate($insurer);
            $prime->age_range()->associate($age_range);
            $prime->franchise()->associate($franchise);
            $prime->tariftype()->associate($tarif_type);
            $prime->canton()->associate($canton);
            $prime->save();
        }, true);
        $this->info(\App\Models\Prime::count());
    }
}
