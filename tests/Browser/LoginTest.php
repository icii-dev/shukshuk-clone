<?php

namespace Tests\Browser;

use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /** @test */
    public function login_success($user = null){
        if(!$user){
            $user = new User([
                'email'=>'cau2binhdinh@gmail.com',
                'password'=>'123123123',
                'full_name'=>'Tin Tran'
            ]);
        }

        $this->browse(function (Browser $browser) use ($user){
           $browser
               ->visit('/')
               ->click('#navLogin')
               ->type('#emailLogin', $user->email)
               ->type('#passwordLogin', $user->password)
               ->press('#btnLogin')
               ->waitForReload()
               ->assertSee($user->full_name);
        });
    }

    /**
     * @test
     */
    public function logout(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('#dropdownUserNav')
                ->click('@btn-logout')
            ->assertSee("Log In");
        });
    }
}
