<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;
     #[test]
     public function it_can_load_livewire_component()
     {
         $this->browse(function (Browser $browser) {
             $browser->visit('/page-avec-composant')
                     ->waitForLivewire()
                     ->assertSee('Texte attendu dans votre composant')
                     ->assertPresent('@un-element-de-votre-composant');
         });
     }
 
     #[test]
     public function it_can_interact_with_livewire_component()
     {
         $this->browse(function (Browser $browser) {
             $browser->visit('/page-avec-composant')
                     ->waitForLivewire()
                     ->type('@input-field', 'Texte de test')
                     ->waitForLivewire()->click('@button-submit')
                     ->assertSee('Résultat attendu');
         });
     }
 }
