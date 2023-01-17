<?php

namespace App\Console\Commands;

use App\Model\Order;
use App\Model\Payment;
use App\Model\Product;
use App\Model\ProductOption;
use App\Model\ProductOptionValue;
use App\Service\ProductService;
use App\Service\StoreService;
use Faker\Factory;
use Illuminate\Console\Command;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fake-data {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var StoreService
     */
    private $storeService;
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        StoreService $storeService,
    ProductService $productService
    ) {
        parent::__construct();
        $this->storeService = $storeService;
        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'order':
                for ($i = 0; $i < 20; ++$i) {
                    $this->doGenerateOrder();
                }

                break;
        }
    }

    private function doGenerateOrder()
    {
        $faker = Factory::create();

        // Input
        $storeSlug = 'saepe-qui-eligendi-unde-et-deleniti-aut';
        $userOrderId = '1';

        $store = $this->storeService->getPublishedBySlug($storeSlug);

        $products = $this->productService->getAllProductOfStore($store);

        // Pick products
        $pickProducts = $faker->randomElements($products);

        $subTotal = 0;
        $total = 0;

        $checkoutId = 0;

        // Create payment
        $payment = Payment::create([
            'id' => uniqid('xendit_'),
            'status' => 'paid',
            'currency' => '',
            'invoice_url' => 'http://link-to-invoice.url',
        ]);

        /** @var Order $order */
        $order = Order::create([
            'id' => uniqid('SHUK'),
            'user_id' => $userOrderId,
            'billing_email' => $faker->email,
            'billing_name' => $faker->name,
            'billing_address' => $faker->address,
            'billing_province' => 10,
            'billing_city' => 10,
            'billing_district' => 10,
            'billing_phone' => $faker->phoneNumber,
            'billing_name_on_card' => $faker->name,
            'billing_discount' => 0,
            'billing_discount_code' => '',
            'billing_subtotal' => $subTotal,
            'billing_tax' => 0,
            'billing_total' => $total,
            'error' => '',
            'store_id' => $store->id,
            'payment_id' => $payment->id,
            'checkout_id' => $checkoutId,
        ]);

        // Save order detail
        /** @var Product $product */
        foreach ($pickProducts as $product) {
            $quantity = random_int(1, 5);
            $price = $quantity * $product->price;

            $subTotal += $price;

            // Pick option
            $options = [];
            if (count($product->options)) {
                /** @var ProductOption $option */
                $option = $faker->randomElement($product->options);

                /** @var ProductOptionValue $optionValue */
                $optionValue = $faker->randomElement($option->values);

                $options[$option->name] = $optionValue->name;
            }

            $order->orderProducts()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'options' => $options,
                'subtotal' => $price,
                'note' => $faker->text(50),
            ]);
        }

        // calculate total from subtotal
        $total = $subTotal;

        $payment->currency = $total;
        $payment->save();

        $order->billing_total = $total;
        $order->billing_subtotal = $subTotal;
        $order->status = Order::STATUS_NEW;
        $order->save();
    }
}
