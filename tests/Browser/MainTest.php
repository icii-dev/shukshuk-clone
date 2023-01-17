<?php

namespace Tests\Browser;

use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MainTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group main
     * @test
     */
    public function main_test()
    {
            $sellerTest = new SellerTest();
//            $adminTest = new AdminTest();
            $buyerTest = new CartTest();
            $loginTest = new LoginTest();
//
//            $sellerTest->register_account();
//            $sellerTest->register_as_seller_individual();
//
//            $adminTest->admin_accept_new_store();
//
//            $loginTest->logout();
            $loginTest->login_success(new User([
                    'email'=>'auto.seller@shukshuk.com',
                    'password'=>'123123123'
                ]));

            $sellerTest->add_a_simple_product();
//            $sellerTest->add_a_full_product();
//            $sellerTest->edit_product();

            $loginTest->logout();
            $buyerTest->login_buyer();
            $buyerTest->add_product_to_cart("Auto Test Product 1");
            $buyerTest->go_checkout_page();
            $buyerTest->checkout();

    }

    /**
     * @group buyer
     * @test
     */
    public function buy_a_product(){
        $buyerTest = new CartTest();
        $buyerTest->login_buyer();
        $buyerTest->add_product_to_cart("Auto Test Product 1");
//        $buyerTest->go_checkout_page();
    }
}
