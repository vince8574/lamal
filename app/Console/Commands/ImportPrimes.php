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
        $path = base_path('database/data/primes_2025.csv');
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
                'AI' => 'appenzell Rhodes-Intérieures',
                'AR' => 'appenzell Rhodes-Extérieures',
                'BE' => 'berne',
                'BL' => 'bâle-Campagne',
                'BS' => 'bâle-Ville',
                'FR' => 'fribourg',
                'GE' => 'geneve',
                'GL' => 'glaris',
                'GR' => 'grisons',
                'JU' => 'jura',
                'LU' => 'lucerne',
                'NE' => 'neuchâtel',
                'NW' => 'nidwald',
                'OW' => 'obwald',
                'SG' => 'saint-Gall',
                'SH' => 'schaffhouse',
                'SO' => 'soleure',
                'SZ' => 'schwitz',
                'TG' => 'thurgovie',
                'TI' => 'tessin',
                'UR' => 'uri',
                'VD' => 'vaud',
                'VS' => 'valais',
                'ZH' => 'zurich',
                'ZG' => 'zoug',
                'default' => 'inconnu'
            };


            $armoiriePath = 'images/svg/cantons_svg/';
            $armoirie = match ($row['canton']) {
                'AG' => $armoiriePath . 'argovie.svg',
                'AI' => $armoiriePath . 'appenzell-rhodes-interieur.svg',
                'AR' => $armoiriePath . 'appenzell-rhodes-exterieur.svg',
                'BE' => $armoiriePath . 'berne.svg',
                'BL' => $armoiriePath . 'bale-campagne.svg',
                'BS' => $armoiriePath . 'bale-ville.svg',
                'FR' => $armoiriePath . 'fribourg.svg',
                'GE' => $armoiriePath . 'geneve.svg',
                'GL' => $armoiriePath . 'glaris.svg',
                'GR' => $armoiriePath . 'grisons.svg',
                'JU' => $armoiriePath . 'jura.svg',
                'LU' => $armoiriePath . 'lucerne.svg',
                'NE' => $armoiriePath . 'neuchatel.svg',
                'NW' => $armoiriePath . 'nidwald.svg',
                'OW' => $armoiriePath . 'obwald.svg',
                'SG' => $armoiriePath . 'saint-gall.svg',
                'SH' => $armoiriePath . 'schaffhouse.svg',
                'SO' => $armoiriePath . 'soleure.svg',
                'SZ' => $armoiriePath . 'schwitz.svg',
                'TG' => $armoiriePath . 'thurgovie.svg',
                'TI' => $armoiriePath . 'tessin.svg',
                'UR' => $armoiriePath . 'uri.svg',
                'VD' => $armoiriePath . 'vaud.svg',
                'VS' => $armoiriePath . 'valais.svg',
                'ZH' => $armoiriePath . 'zurich.svg',
                'ZG' => $armoiriePath . 'zoug.svg',
                'default' => ''
            };


            // get the region code from the string PR-REG CH0
            $row['region_code'] = str_replace('PR-REG CH', '', $row['region_code']);


            $canton = Canton::updateOrCreate([
                'key' => $row['canton']
            ], [
                'key' => $row['canton'],
                'name' => $canton_name,
                'armoirie' => $armoirie
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
