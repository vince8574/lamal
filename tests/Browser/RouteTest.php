<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class RouteTest extends DuskTestCase
{
    use DatabaseMigrations;
     #[Test]
     public function it_can_load_livewire_component()
     {
         $this->browse(function (Browser $browser) {
            $sizes = [
                ['width' => 375, 'height' => 667, 'device' => 'mobile_portrait'], // écran de petits natels portrait
                ['width' => 667, 'height' => 375, 'device' => 'mobile_landscape'], // écran de petits natels paysage
                // ['width' => 768, 'height' => 1024, 'device' => 'tablet_portrait'], // écran de tablette portrait
                // ['width' => 1024, 'height' => 768, 'device' => 'tablet_landscape'], // écran de laptop paysage
                ['width' => 1366, 'height' => 768, 'device' => 'laptop'], // écran de laptop 
                ['width' => 1920, 'height' => 1080, 'device' => 'desktop'], // écran de bureau standard
                ['width' => 3840, 'height' => 1080, 'device' => 'xtralarge'], // écran extra large

            ];
            foreach ($sizes as $size) {
                try {
                        $browser->visit('/search')
                            ->screenshot("searchpage-welcome-{$size['device']}");
                }catch (\Throwable $e) {
                    // Capturez toute erreur et prenez une capture d'écran
                    $browser->screenshot('error-page-search');
                    throw $e;
                }
            }

         });
     }
 
     
 }
