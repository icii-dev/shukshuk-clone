<?php

namespace App\Service;

use App\Dto\Shipping\OrderShippingOptionItem;
use App\Model\ProductVariant;
use App\Model\Store;
use App\Model\UserAddress;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Model\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartService
{
    /**
     * @var UserAddressService
     */
    private $userAddressService;

    /**
     * @var ShippingService
     */
    private $shippingService;

    /**
     * @var array
     */
    private $checkoutCart;
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(
        UserAddressService $userAddressService,
        ShippingService $shippingService,
        ProductService $productService
    ) {
        $this->userAddressService = $userAddressService;
        $this->shippingService = $shippingService;
        $this->productService = $productService;
    }

    function getCart()
    {
        return Cart::instance('shopping')->content();
    }

    function checkCartAndCreateCartbyIdStore($cart)
    {
        // Check race condition when there are less items available to purchase
        // check is price update
        // create list products in cart sort by store_id
        $productsInCart = array();
        $isUpdated = false;
        foreach ($cart as $itemCart) {
            $item = Product::with('store')->find($itemCart->id);
            //check quality of product in stock
            if ($item->quantity < $itemCart->qty) {
                return response()->json(['errors' => ['Not enough ' . $item->name . ' in stock.']], 400);
            }
            //is price update
            $item->price = priceDiscountNotFormat($item->price, $item->discount);
//            return response()->json(['errors' => ['One ' . $item->price]], 400);
            if ($item->price != $itemCart->price) {
                Cart::instance('shopping')->update($itemCart->rowId, ['price' => $item->price]);
                $isUpdated = true;
            }

            // create array list products in cart sort by store_id
            $item['qty'] = $itemCart->qty;
            $item['subtotal'] = $item->price * $item['qty'];
            if (empty($productsInCart[$item->store_id])) {
                $productsInCart[$item->store_id] = array();
            }
            array_push($productsInCart[$item->store_id], $item);
        }
        if ($isUpdated) {
            return response()->json(['errors' => ['One or more products have updated prices'], 'reload' => true], 400);
        }
        return $productsInCart;
    }

    public function getUserAddressPicked()
    {
        if (!auth()->user()) {
            return null;
        }

        $userAddressArr = session()->get('checkout.user_address');

        if (!$userAddressArr) {
            $userAddress = $this->userAddressService->getDefaultOfUser(auth()->user());

            if ($userAddress) {
                $userAddressArr = $userAddress->getAttributes();
                $userAddressArr['ship_code'] = $userAddress->district['ship_code'];
            }
        }

        return $userAddressArr;
    }

    public function getCartContentGroupByStore($buyNowCart = false)
    {
        /** @var \Gloudemans\Shoppingcart\Cart $cart */
        $cart = $buyNowCart ?
            Cart::instance('buynow') :
            Cart::instance('shopping');

        $cartContentGroupByStore = [];
        foreach ($cart->content() as $cartKey => $cartItem) {
            $storeId = $cartItem->options->store_id;

            if (!isset($cartContentGroupByStore[$storeId])) {
                $cartContentGroupByStore[$storeId] = [
                    'id'       => $storeId,
                    'products' => []
                ];
            }

            $cartContentGroupByStore[$storeId]['products'][$cartKey] = $cartItem;
        }

        return $cartContentGroupByStore;
    }

    public function getCheckoutCart($checkoutId = null, $buyNowCart = false)
    {
        if ($checkoutId && session()->has($checkoutId)) {
            return session()->get($checkoutId);
        }

        // Generate checkout id
        if (!$checkoutId) {
            $checkoutId = 'ref-' . Str::uuid()->toString();
        }

        $cartContentGroupByStore = $this->getCartContentGroupByStore($buyNowCart);
        // Extract list store id
        $storeIds = array_map(function ($item) {
            return $item['id'];
        }, $cartContentGroupByStore);

        // Find list stores
        $storeCollection = Store::with('district')->whereIn('id', $storeIds)->get()
            ->keyBy('id');

        // Extract product id
        $productIds = [];
        foreach ($cartContentGroupByStore as $itemGroupByStore) {
            /** @var CartItem $cartItem */
            foreach ($itemGroupByStore['products'] as $cartItem) {
                $productIds[] = $cartItem->id;
            }
        }
        if (count($productIds)) {
            $productCollection = $this->productService->getProductByIds($productIds);
        } else {
            $productCollection = Collection::make([]);
        }

        // Extract list product id
        $userAddressPicked = $this->getUserAddressPicked();

        $checkoutCart = [
            'buy_now_cart'  => $buyNowCart,
            'checkout_id'   => $checkoutId,
            'store_orders'  => [],
            'buyer_address' => [],

            'total_items'         => 0,
            'total_shipping_fee'  => 0,
            'total_insurance_fee' => 0,

            'subtotal' => 0,
            'total'    => 0,
        ];

        foreach ($cartContentGroupByStore as $itemGroupByStore) :
            /** @var Store $store */
            $store = $storeCollection->get($itemGroupByStore['id']);

            if (!$store) {
                // @todo: remove all items of this store from cart
                continue;
            }

            $storeOrder = [
                'id'                 => $store->id,
                'name'               => $store->name,
                'ship_code'          => object_get($store, 'district.ship_code'),
                'logo_url'           => getStoreAvatarUrl($store->avatar_image),
                'url'                => route('store.index', ['slug' => $store->slug], true),
                'subtotal'           => 0,
                'vat_fee'            => 0,
                'discount_amount'    => 0,
                'shipping_fee'       => 0,
                'insurance_fee'      => 0,
                'total'              => 0,
                'total_weight'       => 0,
                'enable_insurance'   => false,
                'shipping_option_id' => null,
                'shipping_options'   => null,
                'products'           => [],
                'error'              => false,
                'error_message'      => null,
                'selected'           => true
            ];

            /** @var CartItem $cartItem */
            foreach ($itemGroupByStore['products'] as $cartItem) {
                /** @var Product $product */
                if (!$product = $productCollection->where('id', $cartItem->id)->first()) {
                    continue;
                }

                $productVariant = $product->variants()
                    ->where('id', $cartItem->options->get('product_variant_id'))
                    ->first();

                if (!$productVariant) {
                    continue;
                }

                $_product = [
                    'id'                 => $cartItem->id,
                    'row_id'             => $cartItem->rowId,
                    'selected'           => true,
                    'thumbnail_url'      => getProductImageUrl($cartItem->options->thumbnail),
                    'thumbnail'          => $cartItem->options->thumbnail,
                    'name'               => $cartItem->name,
                    'quantity'           => (int)$cartItem->qty,
                    'price'              => $cartItem->price,
                    'price_old'          => $cartItem->options->get('oldPrice'),
                    'discount_percent'   => $cartItem->options->get('discount'),
                    'discount_type'      => $cartItem->options->get('discount_type'),
                    'stock'              => $productVariant->quantity,
                    'weight'             => $product->weight,
                    'note'               => $cartItem->options->get('note'),
                    'options'            => $cartItem->options->get('options'),
                    'total'              => round($cartItem->price * $cartItem->qty, 2),
                    'url'                => route('product.show', $cartItem->options->get('slug')),
                    'error'              => false,
                    'error_message'      => '',
                    'product_variant_id' => $productVariant->id,
                ];
                // @todo: check product update price -> notice to user.

                // @todo: check product out of stock -> notice to user
                if (($_product['stock'] === '' || $_product['stock'] == null) && $_product['quantity'] > $_product['stock']) {
                    $_product['quantity'] = $_product['stock'];
//                    $_product['error_message'] = 'The product is out of stock';
                }

                array_push($storeOrder['products'], $_product);
            }

            $checkoutCart['store_orders'][] = $storeOrder;
        endforeach;

        session()->put($checkoutId, $checkoutCart);
        session()->save();

//        $userAddress = $this->userAddressService->getLastUsedAddressForUser(
//            auth()->user()
//        );
//
//        if ($userAddress) {
//            $this->setUserAddress($userAddress);
//        } else {
//            $this->updateAllTotalPrice($checkoutId);
//        }

        $this->updateAllTotalPrice($checkoutId);

        return $this->getCheckoutCart($checkoutId);
    }

    public function deleteRowId($rowId)
    {
        $cart = Cart::instance('shopping');

        $cart->remove($rowId);
    }

    public function updateQuantity($rowId, $quantity, $checkoutId)
    {
        $quantity = (int)$quantity;
        $quantity = max(0, $quantity);

        $checkoutCart = $this->getCheckoutCart($checkoutId);

        foreach ($checkoutCart['store_orders'] as $kStore => $storeOrder) {
            foreach ($storeOrder['products'] as $kProduct => $product) {
                if ($product['row_id'] != $rowId) {
                    continue;
                }
                if (($product['stock'] != Product::STOCK_EMPTY) && ($product['stock'] < $quantity)) {
                    continue;
                }

                if ($quantity == 0) {
                    unset($checkoutCart['store_orders'][$kStore]['products'][$kProduct]);

                    if (count($checkoutCart['store_orders'][$kStore]['products']) === 0) {
                        unset($checkoutCart['store_orders'][$kStore]);
                    }
                } else {
                    $checkoutCart['store_orders'][$kStore]['products'][$kProduct]['quantity'] = $quantity;

                }
                try {
                    if (isset($checkoutCart['buy_now_cart']) && $checkoutCart['buy_now_cart']) {
                        Cart::instance('buynow')->update($rowId, $quantity);
                    } else {
                        Cart::instance('shopping')->update($rowId, $quantity);
                    }
                } catch (\Exception $exception) {
                    //
                }
            }
        }

        session()->put($checkoutId, $checkoutCart);
        session()->save();

        $this->updateAllTotalPrice($checkoutId);
        $this->updateAllShippingFee($checkoutId);
    }

    public function changeSelected($rowId, $selected, $checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);
        foreach ($checkoutCart['store_orders'] as $kStore => $storeOrder) {
            $checkoutCart['store_orders'][$kStore]['selected'] = true;
            foreach ($storeOrder['products'] as $kProduct => $product) {
                if ($product['row_id'] == $rowId) {
                    $checkoutCart['store_orders'][$kStore]['products'][$kProduct]['selected'] = $selected;
                }
                if ($checkoutCart['store_orders'][$kStore]['products'][$kProduct]['selected'] == false) {
                    $checkoutCart['store_orders'][$kStore]['selected'] = false;
                }

            }
        }
        session()->put($checkoutId, $checkoutCart);
        session()->save();

        $this->updateAllTotalPrice($checkoutId);
        $this->updateAllShippingFee($checkoutId);
    }

    public function changeSelectedForStore($storeId, $selected, $checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);
        foreach ($checkoutCart['store_orders'] as $kStore => $storeOrder) {
            if ($storeOrder['id'] == $storeId) {
                foreach ($storeOrder['products'] as $kProduct => $product) {
                    $checkoutCart['store_orders'][$kStore]['products'][$kProduct]['selected'] = $selected;
                    $checkoutCart['store_orders'][$kStore]['selected'] = $selected;
                }
                break;
            }
        }
        session()->put($checkoutId, $checkoutCart);
        session()->save();

        $this->updateAllTotalPrice($checkoutId);
        $this->updateAllShippingFee($checkoutId);
    }

    public function updateShippingOption($storeId, $shippingOptionId, $checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        // find store
        $storeOrder = null;
        $keyStoreOrder = null;
        foreach ($checkoutCart['store_orders'] as $k => $_storeOrder) {
            if ($_storeOrder['id'] == $storeId) {
                $storeOrder = $_storeOrder;
                $keyStoreOrder = $k;
                break;
            }
        }

        if (!$storeOrder) {
            return;
        }

        // Find option
        /** @var OrderShippingOptionItem $shippingOption */
        $shippingOption = null;
        foreach ($storeOrder['shipping_options'] as $_shippingOption) {
            if ($_shippingOption->id == $shippingOptionId) {
                $shippingOption = $_shippingOption;
                break;
            }
        }
        if (!$shippingOption) {
            return;
        }

        $checkoutCart['store_orders'][$keyStoreOrder]['shipping_option_id'] = $shippingOption->id;
        $checkoutCart['store_orders'][$keyStoreOrder]['shipping_fee'] = $shippingOption->cost;

        session()->put($checkoutId, $checkoutCart);
        session()->save();

        $this->updateAllTotalPrice($checkoutId);
    }

    public function updateShippingInsurance($storeId, $enableInsurance, $checkoutId)
    {
        $enableInsurance = (boolean)$enableInsurance;
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        // find store
        $keyStoreOrder = $this->findStoreOrderKey($storeId, $checkoutId);

        if ($keyStoreOrder === null) {
            return;
        }

        $checkoutCart['store_orders'][$keyStoreOrder]['enable_insurance'] = $enableInsurance;
        session()->put($checkoutId, $checkoutCart);
        session()->save();

        $this->updateAllTotalPrice($checkoutId);
    }

    private function findStoreOrderKey($storeId, $checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        $storeOrderAt = null;

        foreach ($checkoutCart['store_orders'] as $_key => $_storeOrder) {
            if ($_storeOrder['id'] == $storeId) {
                $storeOrderAt = $_key;
                break;
            }
        }

        return $storeOrderAt;
    }

    public function setUserAddress(UserAddress $userAddress, $checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        // Save address to session
        $checkoutCart['buyer_address'] = [
            'id'        => $userAddress->id,
            'ship_code' => object_get($userAddress, 'district.ship_code'),
        ];

        session()->put($checkoutId, $checkoutCart);
        session()->save();

        // refresh all option address picked.
        $this->updateAllShippingFee($checkoutId);
    }

    private function updateAllTotalPrice($checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        // Update product total
        foreach ($checkoutCart['store_orders'] as $_storeIndex => $storeOrder) {
            foreach ($storeOrder['products'] as $_productIndex => $product) {
                $checkoutCart['store_orders'][$_storeIndex]['products'][$_productIndex]['total'] =
                    round($product['price'] * $product['quantity'], 2);
            }
        }

        // Update store: subtotal, total_weight, total
        foreach ($checkoutCart['store_orders'] as $k => $storeOrder) {
            $_subtotal = array_reduce($storeOrder['products'], function ($carry, $item) {
                if ($item['selected']) {
                    $carry += $item['price'] * $item['quantity'];
                }
                return $carry;
            }, 0);

            $_totalWeight = array_reduce($storeOrder['products'], function ($carry, $item) {
                if ($item['selected']) {
                    $carry += $item['weight'] * $item['quantity'];
                }
                return $carry;
            }, 0);

            $checkoutCart['store_orders'][$k]['subtotal'] = $_subtotal;
            $checkoutCart['store_orders'][$k]['total_weight'] = $_totalWeight;

            if ($storeOrder['enable_insurance']) {
                $checkoutCart['store_orders'][$k]['insurance_fee'] = $storeOrder['subtotal'] * config('constants.insurance_fee_percent');// @todo: dynamic it
            } else {
                $checkoutCart['store_orders'][$k]['insurance_fee'] = 0;
            }

            $checkoutCart['store_orders'][$k]['total'] = $checkoutCart['store_orders'][$k]['subtotal'] +
                $checkoutCart['store_orders'][$k]['shipping_fee'] +
                $checkoutCart['store_orders'][$k]['insurance_fee'];
        }

        // Update checkout cart
        $totalItems = 0;
        foreach ($checkoutCart['store_orders'] as $storeOrder) {
            /** @var  $product */
            foreach ($storeOrder['products'] as $product) {
                if ($product['selected']) {
                    $totalItems += $product['quantity'];
                }
            }
        }
        $checkoutCart['total_items'] = $totalItems;

        $checkoutCart['subtotal'] = array_reduce($checkoutCart['store_orders'], function ($carry, $item) {
            $carry += $item['subtotal'];
            return $carry;
        }, 0);

        $checkoutCart['total_shipping_fee'] = array_reduce($checkoutCart['store_orders'], function ($carry, $item) {
            $carry += $item['shipping_fee'];
            return $carry;
        }, 0);

        $checkoutCart['total_insurance_fee'] = array_reduce($checkoutCart['store_orders'], function ($carry, $item) {
            $carry += $item['insurance_fee'];
            return $carry;
        }, 0);

        $checkoutCart['total'] = $checkoutCart['subtotal'] +
            $checkoutCart['total_shipping_fee'] +
            $checkoutCart['total_insurance_fee'];

        session()->put($checkoutId, $checkoutCart);
        session()->save();
    }

    public function updateAllShippingFee($checkoutId)
    {
        $checkoutCart = $this->getCheckoutCart($checkoutId);

        $sellerShipCode = empty($checkoutCart['buyer_address']) ? null : $checkoutCart['buyer_address']['ship_code'];

        if ($sellerShipCode) {
            foreach ($checkoutCart['store_orders'] as $k => $storeOrder) {
                try {
                    $shippingOptions = $this->getShippingOptions(
                        $storeOrder['ship_code'],
                        $sellerShipCode,
                        $storeOrder['total_weight']
                    );
                    if ($storeOrder['total_weight'] == 0) {
                        $shippingOptions[0]->cost = 0;
                    }
                    if (is_array($shippingOptions) && count($shippingOptions)) {

//                        // Pick first
                        $shippingOption = $shippingOptions[0];
                        $checkoutCart['store_orders'][$k]['shipping_option_id'] = $shippingOption->id;
                        $checkoutCart['store_orders'][$k]['shipping_fee'] = $shippingOption->cost;

                        // Cache options
                        $checkoutCart['store_orders'][$k]['shipping_options'] = $shippingOptions;

                        // Reset
                        $checkoutCart['store_orders'][$k]['error'] = false;
                        $checkoutCart['store_orders'][$k]['error_message'] = '';
                    } else {
                        // reset shipping option
                        $checkoutCart['store_orders'][$k]['shipping_options'] = [];

                        $checkoutCart['store_orders'][$k]['error'] = true;
                        $checkoutCart['store_orders'][$k]['error_message'] = 'Does not support shipping';
                    }

                } catch (\Exception $exception) {
                    $checkoutCart['store_orders'][$k]['error'] = true;
                    $checkoutCart['store_orders'][$k]['error_message'] = 'Does not support shipping';
                }
            }
        }

        session()->put($checkoutId, $checkoutCart);
        session()->save();
//        dd($this->getCheckoutCart($checkoutId));
        $this->updateAllTotalPrice($checkoutId);
    }

    /**
     * @param $origin
     * @param $destination
     * @param $weight
     * @return OrderShippingOptionItem[]
     */
    public function getShippingOptions($origin, $destination, $weight)
    {
        $key = sprintf('%s_%s_%s', $origin, $destination, $weight);
        //when select item on checkout page - need update new shipping fee
//        $options = session()->get('_cache_shipping_options.' . $key, null);
//
//        if ($options !== null) {
//            return $options;
//        }

        $options = $this->shippingService->findOptions(
            $origin,
            $destination,
            $weight
        );

        session()->put('_cache_shipping_options.' . $key, $options);
        session()->save();

        return $options;
    }

    public function getShippingOption($origin, $destination, $weight, $optionId)
    {
        try {
            $options = $this->getShippingOptions($origin, $destination, $weight);

            foreach ($options as $option) {
                if ($option->id == $optionId) {
                    return $option;
                }
            }
        } catch (\Exception $exception) {

        }

        return null;
    }

    public function isAvailableInStockWhenAddOne($productId, $productVariant, $qty)
    {
//        return false;
        $productVariantId = $productVariant->id;
        $cart = Cart::instance('shopping')->content();
        $hasItem = $cart->search(function ($cartItem, $rowId) use ($productId, $productVariantId) {
            return ($cartItem->id == $productId) && ($cartItem->options->product_variant_id == $productVariantId);
        });
        if ($hasItem) {
            $qtyCheck = $cart->get($hasItem)->qty + $qty;
        } else {
            $qtyCheck = $qty;
        }

        if ($productVariant->quantity != ProductVariant::STOCK_EMPTY
            && $productVariant->quantity < $qtyCheck) {
            return false;
        }
        return true;
    }

    public function isAvailableInStock($productId, $productVariant, $qty)
    {
//        $productVariantId = $productVariant->id;
//        $cart = Cart::instance('shopping')->content();
//        $hasItem = $cart->search(function ($cartItem, $rowId) use ($productId, $productVariantId) {
//            return ($cartItem->id == $productId) && ($cartItem->options->product_variant_id == $productVariantId);
//        });

        if ($productVariant->quantity != ProductVariant::STOCK_EMPTY && $productVariant->quantity < $qty) {
            return false;
        }
        return true;
    }
}
