<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Closure;
use App\Console\Commands\Trait\Csv;
use App\Models\Canton;
use App\Models\City;
use App\Models\District;
use App\Models\Municipality;

class ImportRegions extends Command
{
    use Csv;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-regions';

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
        $path = base_path('database/data/regions.csv');
        $headers = ['npa', 'localite', 'canton', 'region', 'ofs', 'commune', 'district'];

    //    $data = [];

        $this->parse($path,$headers,function($row){
            $district = District::firstOrCreate([
                'name'=>$row['district'],
                'canton_id'=>Canton::where('key',$row['canton'])->first()->id
            ]);
            $municipality = Municipality::firstOrCreate([
                'name'=>$row['commune'],
                'district_id'=>$district->id,
                'ofs_number'=>$row['ofs']
            ]);
            $city = City::firstOrCreate([
                'name'=>$row['localite'],
                'npa'=>$row['npa'],
                'municipality_id'=>$municipality->id,
                'region_code'=>$row['region']
            ]);
        },true);

    }
}
