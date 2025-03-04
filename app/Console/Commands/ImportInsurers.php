<?php

namespace App\Console\Commands;

use App\Console\Commands\Trait\Csv;
use Illuminate\Console\Command;

class ImportInsurers extends Command
{
    use Csv;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-insurers';

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
        $path = base_path('database/data/assureurs_CH.csv');
        $headers = ['bag_number', 'name', 'loc'];

        //    $data = [];

        $this->parse($path, $headers, function ($row) {
            $row['bag_number'] = str_pad($row['bag_number'], 4, '0', STR_PAD_LEFT);
            \App\Models\Insurer::firstOrCreate(
                ['bag_number' => $row['bag_number']],
                $row
            );
        });
        $this->info(\App\Models\Insurer::count());
        /*   if(($handle = fopen($path, 'r')) !== false){
               while(($row = fgetcsv($handle, 1000, ';')) !== false) {
                   $row = array_slice($row, 0, 3);
                   if (count($row) != count($headers)) {
                       throw new \Exception("wrong col num");
                   }
                   $row = array_combine($headers, $row);

                   $row['bag_number']= str_pad($row['bag_number'],4,"0",STR_PAD_LEFT);
                   \App\Models\Insurer::firstOrCreate(
                       ['bag_number'=>$row['bag_number']],
                       $row
                   );
               }
               fclose($handle);

               $this->info(\App\Models\Insurer::count());
           }else {
               echo "Impossible d'ouvrir le fichier CSV.";
           }*/
        // dump($data);
    }
}
