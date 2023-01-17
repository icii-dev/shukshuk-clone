<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model{
/**
 * App\Model\AddressCity
 *
 * @property int $id
 * @property string $province_id
 * @property string $name
 * @property string|null $tmpid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\AddressCity[] $districts
 * @property-read int|null $districts_count
 * @property-read \App\Model\AddressProvince $province
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressCity whereTmpid($value)
 */
	class AddressCity extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\AddressDistrict
 *
 * @property int $id
 * @property string $regency_id
 * @property string $name
 * @property string|null $ship_code
 * @property string|null $slug
 * @property string|null $tmpid
 * @property-read \App\Model\AddressCity $city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereRegencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereShipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressDistrict whereTmpid($value)
 */
	class AddressDistrict extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\AddressProvince
 *
 * @property int $id
 * @property string $name
 * @property string|null $tmpid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\AddressCity[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AddressProvince whereTmpid($value)
 */
	class AddressProvince extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Bank
 *
 * @property int $id
 * @property string $name
 * @property string $bank_code
 * @property string $account_holder_name
 * @property string $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Store[] $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank whereUpdatedAt($value)
 */
	class Bank extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $order
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Store[] $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\CategoryProduct
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryProduct whereUpdatedAt($value)
 */
	class CategoryProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Component
 *
 * @property int $id
 * @property string $key
 * @property string $display_name
 * @property string $value
 * @property string|null $details
 * @property string $type
 * @property int $order
 * @property string|null $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Component whereValue($value)
 */
	class Component extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Coupon
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property int|null $value
 * @property int|null $percent_off
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon wherePercentOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Coupon whereValue($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\DeliveryUnit
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryUnit whereUpdatedAt($value)
 */
	class DeliveryUnit extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Disbursement
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $bank_code
 * @property string|null $account_holder_name
 * @property string|null $account_number
 * @property int|null $amount
 * @property string|null $description
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Disbursement whereUserId($value)
 */
	class Disbursement extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Industry
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Industry whereUpdatedAt($value)
 */
	class Industry extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Menu
 *
 * @todo : Refactor this class by using something like MenuBuilder Helper.
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\MenuItem[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\MenuItem[] $parent_items
 * @property-read int|null $parent_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\MenuItem
 *
 * @property int $id
 * @property int|null $menu_id
 * @property string $title
 * @property string $url
 * @property string $target
 * @property string|null $icon_class
 * @property string|null $color
 * @property int|null $parent_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $route
 * @property string|null $parameters
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\MenuItem[] $children
 * @property-read int|null $children_count
 * @property-read null $translated
 * @property-read \TCG\Voyager\Models\Menu|null $menu
 * @property-read \App\Model\Page $page
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereIconClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem withTranslations($locales = null, $fallback = true)
 */
	class MenuItem extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Order
 *
 * @property string $id
 * @property int|null $user_id
 * @property string|null $billing_email
 * @property string|null $billing_name
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_province
 * @property string|null $billing_district
 * @property string|null $billing_phone
 * @property string|null $billing_name_on_card
 * @property int $billing_discount
 * @property string|null $billing_discount_code
 * @property int|null $billing_shipping_fee
 * @property int|null $billing_insurance_fee
 * @property int $billing_subtotal
 * @property int $billing_tax
 * @property int $billing_total
 * @property string|null $shipping_option
 * @property int|null $total_weight Gram
 * @property string $payment_gateway
 * @property string $payment_id
 * @property string $checkout_id
 * @property int $shipped
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $store_id
 * @property int $status
 * @property string|null $shipping_id
 * @property-read \App\Model\AddressCity|null $city
 * @property-read \App\Model\AddressDistrict|null $district
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\OrderProduct[] $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \App\OrderShipping $orderShipping
 * @property-read \App\Model\Payment $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Model\AddressProvince|null $province
 * @property-read \App\Model\Store|null $store
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingDiscountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingInsuranceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingNameOnCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereBillingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereCheckoutId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereShipped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereShippingOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\OrderProduct
 *
 * @property int $id
 * @property string|null $order_id
 * @property int|null $product_id
 * @property int $quantity
 * @property string|null $note
 * @property array|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $subtotal
 * @property-read mixed $name
 * @property-read \App\Model\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereUpdatedAt($value)
 */
	class OrderProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Payment
 *
 * @property string $id
 * @property string|null $status
 * @property string|null $method
 * @property string|null $channel
 * @property int|null $paid_amount
 * @property string $currency
 * @property string $invoice_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereInvoiceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $details
 * @property int $price
 * @property string $description
 * @property int $featured
 * @property int $quantity
 * @property string|null $image
 * @property array|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $sku
 * @property int|null $discount
 * @property int|null $discount_type
 * @property int|null $status
 * @property int $store_id
 * @property float|null $rating_cache
 * @property int|null $rating_count
 * @property int|null $weight gram
 * @property mixed|null $dimensions mm
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductOptionValue[] $optionValues
 * @property-read int|null $option_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductOption[] $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Model\ProductSites $size
 * @property-read \App\Model\Store $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Wishlist[] $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product mightAlsoLike()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDimensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereRatingCache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereRatingCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereWeight($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ProductOption
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductOptionValue[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOption whereProductId($value)
 */
	class ProductOption extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ProductOptionValue
 *
 * @property int $id
 * @property int $product_option_id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductOptionValue[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductOptionValue whereProductOptionId($value)
 */
	class ProductOptionValue extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ProductSites
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $weight
 * @property int|null $length
 * @property int|null $width
 * @property int|null $height
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductSites whereWidth($value)
 */
	class ProductSites extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Review
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property string|null $images
 * @property int $approved
 * @property int $spam
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Product $product
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review notSpam()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review spam()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereSpam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Seller
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property mixed|null $dob
 * @property string|null $phone
 * @property int|null $nationality_id
 * @property int|null $residence_id
 * @property string|null $id_number
 * @property string|null $proof_image
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Store $store
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereNationalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereProofImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereResidenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Seller whereUserId($value)
 */
	class Seller extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\SocialAccount
 *
 * @property int $user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SocialAccount whereUserId($value)
 */
	class SocialAccount extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Store
 *
 * @property int $id
 * @property int|null $delivery_unit_id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $category_id
 * @property int|null $industry_id
 * @property string|null $description
 * @property int $user_id
 * @property string|null $address
 * @property float|null $lat
 * @property float|null $lng
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $total_favorite
 * @property float|null $rating
 * @property int|null $type
 * @property int $featured
 * @property string|null $cover_image
 * @property array|null $proof_images
 * @property string|null $avatar_image
 * @property int $seller_id
 * @property int $address_province_id
 * @property int $address_city_id
 * @property int $address_district_id
 * @property-read \App\Model\StoreBalance $balance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Bank[] $banks
 * @property-read int|null $banks_count
 * @property-read \App\Model\Category|null $categories
 * @property-read \App\Model\AddressCity $city
 * @property-read \App\Model\DeliveryUnit $delliveryUnit
 * @property-read \App\Model\AddressDistrict $district
 * @property-read \App\Model\Industry|null $industry
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\PaymentMethod[] $paymentMethods
 * @property-read int|null $payment_methods_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Model\AddressProvince $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\StoreRejectCause[] $rejectCause
 * @property-read int|null $reject_cause_count
 * @property-read \App\Model\Seller $seller
 * @property-read \App\Model\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\WishlistStore[] $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereAddressCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereAddressDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereAddressProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereAvatarImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereDeliveryUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereProofImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereTotalFavorite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Store whereUserId($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\StoreAddress
 *
 * @property int $id
 * @property int $store_id
 * @property string|null $province_id
 * @property string|null $regency_id
 * @property string|null $district_id
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereRegencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreAddress whereUpdatedAt($value)
 */
	class StoreAddress extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\StoreBalance
 *
 * @property int $id
 * @property int $store_id
 * @property int $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Store $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreBalance whereUpdatedAt($value)
 */
	class StoreBalance extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\StoreRejectCause
 *
 * @property int $id
 * @property int $store_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\StoreRejectCause whereUpdatedAt($value)
 */
	class StoreRejectCause extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Transaction
 *
 * @property int $id
 * @property int $store_id
 * @property int $amount
 * @property string $type
 * @property int $status
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $avatar
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\UserAddress $address
 * @property-read mixed $full_name
 * @property mixed $locale
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \TCG\Voyager\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \App\Model\Seller $seller
 * @property-read \App\Model\Store $store
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Wishlist[] $wishlist
 * @property-read int|null $wishlist_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\WishlistStore[] $wishlistStore
 * @property-read int|null $wishlist_store_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\UserAddress
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $province_id
 * @property string|null $regency_id
 * @property string|null $district_id
 * @property string|null $recipient_name
 * @property string|null $addresses
 * @property string|null $phone
 * @property string|null $date_of_birth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property int|null $is_default
 * @property-read \App\Model\AddressCity $city
 * @property-read \App\Model\AddressDistrict|null $district
 * @property-read mixed $full_address
 * @property-read \App\Model\AddressProvince|null $province
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereRegencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAddress whereUpdatedAt($value)
 */
	class UserAddress extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Wishlist
 *
 * @property int $product_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Product $product
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Wishlist whereUserId($value)
 */
	class Wishlist extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\WishlistStore
 *
 * @property int $store_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Store $store
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\WishlistStore whereUserId($value)
 */
	class WishlistStore extends \Eloquent {}
}

namespace App{
/**
 * App\OrderShipping
 *
 * @property int $id
 * @property string $order_id
 * @property string|null $shipping_referrer_id
 * @property string|null $shipping_option
 * @property int|null $cost
 * @property string|null $expect_start
 * @property string|null $expect_finish
 * @property int|null $retry_count
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereExpectFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereExpectStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereRetryCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereShippingOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereShippingReferrerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShipping whereUpdatedAt($value)
 */
	class OrderShipping extends \Eloquent {}
}

namespace App{
/**
 * App\OrderShippingHistory
 *
 * @property int $id
 * @property int $order_shipping_id
 * @property string $order_id
 * @property string|null $message
 * @property string|null $tracking_code
 * @property string|null $action_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereActionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereOrderShippingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereTrackingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderShippingHistory whereUpdatedAt($value)
 */
	class OrderShippingHistory extends \Eloquent {}
}

