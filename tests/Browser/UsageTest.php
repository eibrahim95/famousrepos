<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Results will show here');
            $browser->press("Submit")
                ->assertSee('Result (');
            $browser->select('count', '50')->press("Submit")->waitFor("tbody");
            $this->assertEquals(count($browser->elements('tbody tr')), 50);
            $browser->select('count', '100')->press("Submit")->waitFor("tbody");
            $this->assertEquals(count($browser->elements('tbody tr')), 100);
            $browser->type('lang', 'Python')->press("Submit")->waitFor("tbody");
            $browser->select('count', '10')->press("Submit")->waitFor("tbody");
            $this->assertEquals(count($browser->elements('tbody tr')), 10);
            foreach ($browser->elements("tr td:nth-child(5)") as $el){
                $t = $el->getText();
                if ($t !== ""){
                    $this->assertEquals($t, 'Python');
                }
            }
        });
    }
}
