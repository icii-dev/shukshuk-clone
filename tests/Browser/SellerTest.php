<?php

namespace Tests\Browser;

use App\Model\Product;
use App\Model\Seller;
use App\Model\User;
use App\Service\ProductService;
use App\Service\StoreService;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SellerTest extends DuskTestCase
{
    private $seller = [
        'email'=>'auto.seller@shukshuk.com',
        'password'=>'123123123'
    ];
//    use DatabaseTransactions;
    /**
     * A Dusk test seller.
     * @group seller-register-1
     * @test
     */
    public function register_account()
    {
        $users = User::where('email',$this->seller['email'])->get();
        foreach ($users as $user){
            if($user->store){
                $storeService = new StoreService();
                $storeService->delete($user->store);
            }
            $user->seller()->delete();
            $user->delete();
        }
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@nav-register')
                ->pause(500)
                ->type('firstName', 'seller')
                ->type('lastName', 'auto')
                ->type('email', $this->seller['email'])
                ->type('password', '123123123')
                ->type('password_confirmation', '123123123')
                ->click('#btnRegister')
                ->waitFor('#dropdownUserNav', 8)
                ->click('#dropdownUserNav')
                ->assertSee('Log Out');
        });
    }

    /**
     * A Dusk test seller.
     * @group seller-register
     * @test
     */
    public function register_as_seller_individual(){
        Seller::where('email',$this->seller['email'])->delete();
        $this->browse(function (Browser $browser){
           $browser->visit(route('seller.register'))
               ->type('first_name', 'Seller')
               ->type('last_name', 'Auto')
               ->type('email', $this->seller['email'])
               ->script([
                   "document.querySelector('#dob').value = '19-02-1994'",
                    ]);
           $browser->type('phone', '+84989083484')
               ->type('id_number', '123456789')
               ->attach('proof_image_upload', __DIR__.'/src/register-seller/id-card.png')
               ->click('@btn-continue')
               ->waitForText('Store Details')
               ->select('type', '1')
               ->select('industry_id')
               ->select('category_id')
               ->type('name', 'Auto Seller')
               ->type('description', 'This is a auto store')
               ->attach('avatar_image_upload', __DIR__.'/src/register-seller/store-cover.jpeg')
               ->select('address_province_id', '11')
               ->waitFor('.cities-options')
               ->scrollTo('#cities')
               ->select('@address-city-id', '156')
               ->waitFor('.district-options',10)
               ->select('@address-district-id', '2024')
               ->type('address', '122, auto address')
               ->click('@btn-continue')
               ->waitFor('.bank-code-options')
               ->select('bank_code')
               ->type('account_holder_name', 'Auto seller bank')
               ->type('account_number', '123123123')
               ->click('@btn-continue')
               ->waitForRoute('seller.product.index')
               ->assertSee("Your store is waiting for approval!");

        });
    }

    /**
     * @group seller-add-product
     * @test
     */
    public function add_a_simple_product(){
        $this->browse(function (Browser $browser){
            $product = new Product([
                'name' => "Auto Test Product 1",
                'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of typ",
                'price' => 2000,
                'discount' => 1000,
                'quantity' => 5,
                'weight' => 500,
                'length' => 10,
                'width' => 15,
                'height' => 20
            ]);

            $this->delete_old_product($product->name);
            $browser->visitRoute('seller.product.index')
               ->click('@add-product')
               ->type('name', $product->name)
               ->select('category_id');
            $this->typeInCKEditor('#cke_description iframe', $browser, $product->description);

//            $browser->type('quantity', $product->quantity)
//               ->type('price', $product->price)
//               ->type('discount', $product->discount)
//               ->attach('#photo-0', __DIR__ . '/src/products/pro1.jpeg')
//               ->attach('#photo-1', __DIR__ . '/src/products/pro1_1.jpeg')
//               ->attach('#photo-2', __DIR__ . '/src/products/pro1_2.jpeg')
            $browser->type('weight', $product->weight)
               ->type('length', $product->length)
               ->type('width', $product->width)
               ->type('height', $product->height)
               ->press('Add product Details');
//           ->assertRouteIs('seller.product.index');

            $browser
                ->type('variants[-1][price]', $product->price)
                ->type('variants[-1][discount_value]', $product->discount)
                ->attach('#photo-0', __DIR__ . '/src/products/pro1.jpeg')
               ->attach('#photo-1', __DIR__ . '/src/products/pro1_1.jpeg')
               ->attach('#photo-2', __DIR__ . '/src/products/pro1_2.jpeg')
                ->press('Save Product');

        });
    }

    public function typeInCKEditor ($selector, $browser, $text)
    {
        $ckIframe = $browser->elements($selector)[0];
        $browser->driver->switchTo()->frame($ckIframe);
        $body = $browser->driver->findElement(WebDriverBy::xpath('//body'));
        $body->sendKeys($text);
        $browser->driver->switchTo()->defaultContent();
    }

    /**
     * @group seller-add-product
     * @test
     */
    public function add_a_full_product(){
        $this->browse(function (Browser $browser){

            $product = new Product([
                'name' => "Auto Test Product Full Options",
                'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of typ",
                'price' => 1000,
                'discount' => 20,
                'quantity' => 5,
                'weight' => 500,
                'length' => 10,
                'width' => 15,
                'height' => 20
            ]);

            $this->delete_old_product($product->name);

            $browser->loginAs(User::whereEmail($this->seller['email'])->first())
                ->visitRoute('seller.product.index')
                ->click('@add-product')
                ->type('name', $product->name)
                ->select('category_id')
                ->type('description', $product->description)
                ->type('quantity', $product->quantity)
                ->click('@check-quantity-empty')
                ->type('price', $product->price)
                ->click('@check-discount-percent')
                ->type('discount', $product->discount)
                ->attach('#photo-0', __DIR__ . '/src/products/pro1.jpeg')
                ->attach('#photo-1', __DIR__ . '/src/products/pro1_1.jpeg')
                ->attach('#photo-2', __DIR__ . '/src/products/pro1_2.jpeg')
                ->click('@check-option-enabled')
                ->type('options[0]', 'color')
                ->click('.add-option-value');

            $valueInputs = $browser->elements('input[name^="values[0]["]');
            $valueInputs[0]->sendKeys('Red');
            $valueInputs[1]->sendKeys('White');

            $browser->type('weight', $product->weight)
                ->type('length', $product->length)
                ->type('width', $product->width)
                ->type('height', $product->height)
                ->press('Save')
                ->assertRouteIs('seller.product.index');
        });
    }

    public function delete_old_product($proName){
        $pro = Product::whereName($proName)->first();
        if($pro){
            $options = $pro->options;
            foreach ($options as $option){
                $option->values()->delete();
                $option->delete();
            }
            $variants = $pro->variants()->delete();
            $pro->delete();
        }
    }

    /**
     * @group seller-edit-product
     * @test
     */
    public function edit_product(){
        $this->browse(function (Browser $browser){
            $product = Product::whereName('Auto Test Product Full Options')->first();
            if($product){
                $text = ' edit';
                $this->delete_old_product($product->name . $text);
            }

            $browser->loginAs(User::whereEmail($this->seller['email'])->first())
                ->visitRoute('seller.product.edit', $product->id)
                ->type('name', $product->name . $text)
                ->select('category_id')
                ->type('description', $product->description . $text)
                ->click('@check-quantity-empty')
                ->type('quantity', $product->quantity + 3)
                ->type('price', $product->price + 1500)
                ->click('@check-discount-percent')
                ->type('discount', 1500)
                ->attach('#photo-0', __DIR__ . '/src/products/pro1.jpeg')
                ->attach('#photo-1', __DIR__ . '/src/products/pro1_1.jpeg')
                ->attach('#photo-2', __DIR__ . '/src/products/pro1_2.jpeg')
                ->click('@check-option-enabled')
                ->type('weight', $product->weight + 1500)
                ->type('length', $product->length + 5)
                ->type('width', $product->width + 5)
                ->type('height', $product->height + 5)
                ->press('Save')
                ->assertRouteIs('seller.product.index');
        });
    }

}
