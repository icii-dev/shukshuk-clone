<?php

namespace Tests\Browser;

use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends DuskTestCase
{
    /**
     * A Dusk test seller.
     * @group admin
     * @test
     */
    public function admin_accept_new_store(){
        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->click('#dropdownUserNav')
                ->click('@btn-logout');

            $admin = new User([
                'email'=>'cau2binhdinh@gmail.com',
                'password'=>'123123123'
            ]);

            $loginAdmin = new LoginTest();
            $loginAdmin->login_success($admin);

            $browser->visit('/admin')
                ->pause(500)
                ->visitRoute('admin.stores.pending')
                ->waitFor('table > tbody > tr:nth-child(1) > td#bread-actions')
                ->click('table > tbody > tr:nth-child(1) > td#bread-actions > a')
                ->pause(1000)
                ->click('@btn-accept')
                ->assertRouteIs('admin.stores.index');

        });

    }
}
