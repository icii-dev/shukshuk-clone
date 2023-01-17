<?php

namespace Tests\Browser;

use App\Model\Product;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartTest extends DuskTestCase
{
    /** @test  */
    public function login_buyer(){
        $user = new User([
            'email'=>'cau2binhdinh@gmail.com',
            'password'=>'123123123',
            'full_name'=>'Tin Tran'
        ]);

        $this->browse(function (Browser $browser) use ($user){

//            if (!$browser->element('#navLogin')) {
//                $browser->visit('/')
//                    ->click('#dropdownUserNav')
//                    ->click('@btn-logout');
//            }

            $browser
                ->visit('/')
                ->click('#navLogin')
                ->type('#emailLogin', $user->email)
                ->type('#passwordLogin', $user->password)
                ->press('#btnLogin')
                ->waitForText($user->full_name)
                ->assertSee($user->full_name);
        });
    }

    /** @test */
    public function add_product_to_cart($proName = null){

        if($proName){
            $product = Product::whereName($proName)
                                ->first();
        }else{
            $product = Product::where('slug', '314-product-kr-test')
                ->first();
        }

        $this->browse(function (Browser $browser) use ($product){
            $browser->pause(1000);
            $browser->visit('/product/'. $product->slug)
                ->waitFor('#addToCart')
                ->click('#addToCart')
                ->waitFor('#notify-1')
                ->assertSee('Update cart successfully');
        });
    }

    /** @test  */
    public function go_checkout_page(){

        $this->browse(function (Browser $browser){
            $browser->visit('/')
                ->click('#dropdownMainCart')
                ->click('@checkout-bnt')
                ->assertRouteIs('checkout.index', 'cart');
        });
    }

    /** @test  */
    public function checkout(){
        $this->browse(function (Browser $browser){
            $browser->visit(route('checkout.index', 'cart'))
                ->waitUntilMissing('.loading-container')
                ->pause(10000)
                ->press('@btn-make-payment')
                ->waitForText('Pay Now', 20)
                ->click('@test-default-payment')
                ->press('@btn-pay-now')
                ->waitForText('You are in Test Mode', 20)
                ->click('#payment-channel-mandiri')
                ->waitForText('FIND NEAREST ATM', 20)
                ->click('.underline')
                ->waitForText('Payment Successful', 40)
                ->assertSee('Payment Successful');
        });
    }
}
