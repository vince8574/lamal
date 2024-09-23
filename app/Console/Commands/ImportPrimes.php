<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Trait\Csv;
use App\Models\Insurer;

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
        $headers = ['bag_number', 'name', 'loc'];

        //    

        $this->parse($path, $headers, function ($row) {
            $insurer = Insurer::where('bag_number', $mappedRow['insurer_code'])->first();

            if ($insurer) {
                $age_range = AgeRange::firstOrCreate([
                    'key' => $mappedRow['age_range']
                ]);

                $franchise = Franchise::firstOrCreate([
                    'key' => $mappedRow['franchise']
                ]);
                $mappedRow['accident'] = $mappedRow['accident'] == "MIT-UNF";
                $prime = new Prime($mappedRow);
                $prime->insurer()->associate($insurer);
                $prime->age_range()->associate($age_range);
                $prime->franchise()->associate($franchise);
                $prime->save();
            }
        }, true);
        $this->info(\App\Models\Prime::count());
    }
}
