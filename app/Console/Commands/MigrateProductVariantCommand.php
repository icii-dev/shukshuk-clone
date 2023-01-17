<?php

namespace App\Console\Commands;

use App\Model\Product;
use App\Model\ProductVariant;
use App\Service\ProductService;
use Illuminate\Console\Command;

class MigrateProductVariantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-product-variant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
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
        ProductService $productService
    ) {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($firstProductVariant = ProductVariant::first()) {
            throw new \Exception('Require table product_variant to be empty');
        }

        $products = Product::with('options', 'options.values')->get();

        foreach ($products as $product) {
            if ($product->options->count() > 2) {
                logger()->warning(sprintf(
                    'The product %s have large than 2 options', $product->id
                ));

                continue;
            }

            $discountType = $product->discount_type == Product::DISCOUNT_PERCENT ?
                ProductVariant::DISCOUNT_TYPE_PERCENT : ProductVariant::DISCOUNT_TYPE_MONEY;

            $discountValue = $product->discount;

            $isUnlimittedQuantity = $product->quantity == -1 ? true : false;


            $requiredVariants = [];
            if ($product->options->count() === 1) {
                foreach ($product->options[0]->values as $value) {
                    $requiredVariants[] = [$value->id];
                }
            } elseif ($product->options->count() === 2) {
                foreach ($product->options[0]->values as $value1) {
                    foreach ($product->options[0]->values as $value2) {
                        $requiredVariants[] = [$value1->id, $value2->id];
                    }
                }
            } else {
                $requiredVariants[] = [];
            }

            foreach ($requiredVariants as $k => $requiredVariant) {
                $quantity = $isUnlimittedQuantity ? -1 : floor($product->quantity / count($requiredVariants));

                if ($k == count($requiredVariants) - 1) {
                    $quantity = $product->quantity - (floor($product->quantity / count($requiredVariants)) * $k);
                }

                $productVariant = $product->variants()->create([
                    'option_1'       => isset($requiredVariant[0]) ? $requiredVariant[0] : null,
                    'option_2'       => isset($requiredVariant[1]) ? $requiredVariant[1] : null,
                    'options'        => $requiredVariant,
                    'price'          => $product->price,
                    'quantity'       => $quantity,
                    'discount_type'  => $discountType,
                    'discount_value' => $discountValue
                ]);

                if ($k === 0) {
                    $productVariant->images = $product->images;
                }

                if ($product->status == Product::STATUS_ACTIVE) {
                    $product->is_published = 1;
                }

                $product->save();
                $productVariant->save();
            }
        }
    }
}
