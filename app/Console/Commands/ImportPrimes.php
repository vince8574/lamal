<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Trait\Csv;
use App\Models\AgeRange;
use App\Models\Canton;
use App\Models\Franchise;
use App\Models\Insurer;
use App\Models\Prime;

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

            $age_range = AgeRange::firstOrCreate([
                'key' => $row['age_range']
            ]);

            // $franchise_numerique = intval(str_replace('FRA-', '', $row['franchise']));
            $franchise = Franchise::firstOrCreate([
                'key' => $row['franchise']
            ], [
                'key' => $row['franchise'],
                'franchise_label' => $row['franchise'],
                'franchise_numerique' => intval(str_replace('FRA-', '', $row['franchise']))
            ]);

            $canton = Canton::firstOrCreate([
                'key' => $row['canton']
            ], [
                'key' => $row['canton'],
                'name' => $row['canton']
            ]);
            $row['accident'] = $row['accident'] == "MIT-UNF";
            $prime = new Prime($row);
            $prime->insurer()->associate($insurer);
            $prime->age_range()->associate($age_range);
            $prime->franchise()->associate($franchise);
            $prime->canton()->associate($canton);
            $prime->save();
        }, true);
        $this->info(\App\Models\Prime::count());
    }
}
