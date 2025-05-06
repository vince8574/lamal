<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Facebook\WebDriver\WebDriverKeys;


class LoginTest extends DuskTestCase
{
    #[Test]
    public function welcome_desktop()
    {
        $this->browse(function (Browser $browser) {
            $sizes = [
                ['width' => 1920, 'height' => 1080, 'device' => 'desktop'], // écran de bureau standard
                ['width' => 375, 'height' => 667, 'device' => 'mobile'], // écran de petits natels
                ['width' => 768, 'height' => 1024, 'device' => 'tablet'], // écran de tablette
                ['width' => 1366, 'height' => 768, 'device' => 'laptop'], // écran de laptop
                ['width' => 3840, 'height' => 1080, 'device' => 'xtralarge'], // écran extra large
                
            ];
            foreach ($sizes as $size){
            try {

                $browser->visit('/')
                    ->resize($size['width'], $size['height']) 
                    ->screenshot("debug-homepage-{$size['device']}")
                    ->typeSlowly('canton', 'geneve')
                    ->pause(1000)
                    ->keys('#canton', [WebDriverKeys::ENTER])
                    ->pause(1000)
                    ->screenshot("complete-canton-{$size['device']}")
                    ->type('name', 'Ramone Moiloignon')
                    ->screenshot("name-{$size['device']}")
                    ->assertSee('Calculate')
                    ->clickLink('@compare')
                    ->assertPathIs('/search');
            } catch (\Throwable $e) {
                // Capturez toute erreur et prenez une capture d'écran
                $browser->screenshot('error-page');
                throw $e;
            }
        }
        });
    

}  
}
