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
                ['width' => 375, 'height' => 667, 'device' => 'mobile_portrait'], // écran de petits natels portrait
                ['width' => 667, 'height' => 375, 'device' => 'mobile_landscape'], // écran de petits natels paysage
                ['width' => 768, 'height' => 1024, 'device' => 'tablet_portrait'], // écran de laptop 
                ['width' => 1024, 'height' => 768, 'device' => 'tablet_landscape'], // écran de laptop 
                ['width' => 1366, 'height' => 768, 'device' => 'laptop'], // écran de laptop 
                ['width' => 1920, 'height' => 1080, 'device' => 'desktop'], // écran de bureau standard
                ['width' => 3840, 'height' => 1080, 'device' => 'xtralarge'], // écran extra large

            ];
            foreach ($sizes as $size) {
                try {

                    $browser->visit('/')
                        ->resize($size['width'], $size['height'])
                        ->screenshot("debug-homepage-{$size['device']}")
                        ->clickLink('fr')
                        ->pause(1000)
                        ->screenshot("homepage-fr-{$size['device']}")
                        ->clickLink('de')
                        ->pause(1000)
                        ->screenshot("homepage-de-{$size['device']}")
                        ->pause(1000)
                        ->clickLink('it')
                        ->screenshot("homepage-it-{$size['device']}")
                        ->clickLink('en')
                        ->screenshot("homepage-en-{$size['device']}")
                        ->typeSlowly('canton', 'geneve')
                        ->pause(1000)
                        ->keys('#canton', [WebDriverKeys::ENTER])
                        ->pause(1000)
                        ->screenshot("complete-canton-{$size['device']}")
                        ->type('name', 'Ramone Moiloignon')
                        ->screenshot("name-{$size['device']}")
                        ->assertSee('Calculate')
                        ->clickLink('Compare the premiums')
                        ->pause(1000)
                        ->screenshot("compare-premiums-{$size['device']}");
                    // ->assertPathIs('/search');
                } catch (\Throwable $e) {
                    // Capturez toute erreur et prenez une capture d'écran
                    $browser->screenshot('error-page');
                    throw $e;
                }
            }
        });
    }
}
