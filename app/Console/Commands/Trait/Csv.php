<?php

namespace App\Console\Commands\Trait;
use Closure;
use function Laravel\Prompts\spin;
trait Csv{
    public function parse (string $path,array $headers, Closure $callback, bool $skip_header=false):void
    {

        if(($handle = fopen($path, 'r')) === false){
            throw new \Exception("cannot open file");
        }
        // if (($handle = fopen($path, "r")) !== false) {
        //     // Ignorer la première ligne
        //     fgetcsv($handle);
        // }
        spin(
            message:"doing black magic", 
            callback:function() use ($handle,$headers,$callback, $skip_header){
                $skipped=false;
                while(($row = fgetcsv($handle, 0, ';')) !== false) {
                    if($skip_header && !$skipped){
                        $skipped =true;
                        continue;
                    }
                    $row = array_slice($row, 0, 3);
                    if (count($row) != count($headers)) {
                        throw new \Exception("wrong col num");
                    }
                    $row = array_combine($headers, $row);
        
                    $callback($row);
                }

            }
        );
        
        fclose($handle);
    }
}
