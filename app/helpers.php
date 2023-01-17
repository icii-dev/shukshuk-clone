<?php

use Carbon\Carbon;
use App\Service\CartService;

const STORE_AVATAR_PATH = 'img/store-avatar/';
const SELLER_PATH = 'img/seller';

function displaySellerImage($imageLink){
    return asset(SELLER_PATH.'/'.$imageLink);
}

function cartContent()
{
    $cart = new CartService();
    return $cart->getCart();
}

function presentPrice($price)
{
    return money_format('$%i', $price / 1000);
}

function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}

function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}

function productImage($path)
{
    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
}

function userImage($path)
{
    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset("vendor/buyer/Img/avatar-1.png");
}

function getStockLevel($quantity)
{
    if ($quantity > setting('site.stock_threshold', 5)) {
        $stockLevel = '<div class="badge badge-success">In Stock</div>';
    } elseif ($quantity <= setting('site.stock_threshold', 5) && $quantity > 0) {
        $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
    } else {
        $stockLevel = '<div class="badge badge-danger">Not available</div>';
    }

    return $stockLevel;
}

function is_mobile()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }
    return $is_mobile;
}

function getStoreBalance(\App\Model\Store $store){
    return $store->balance?auth()->user()->store->balance->total:'0';
}

function moneyFormat($price)
{
    switch (env('APP_CURRENCY', 'IDR')){
        case 'Rp':
        case 'IDR':
            return "Rp " . amountFormat($price);
        case 'KRW':
            return amountFormat($price).' KRW';
        default:
            return amountFormat($price);
    }


}

function amountFormat($price){
    return number_format($price, 0, '', '.');
}

function priceDiscount($price, $discount = 0, $discount_type = \App\Model\Product::DISCOUNT_MONEY)
{
    if ($discount_type == \App\Model\Product::DISCOUNT_PERCENT || $discount < 100) {
        $price = $price * (100 - $discount) / 100;
    } else {
        $price = $price - $discount;
    }
    return moneyFormat($price);
}

function priceDiscountNotFormat($price, $discount = 0)
{
    return $price = $price * (100 - $discount) / 100;
}

function showDiscountValue($discount, $discount_type = \App\Model\Product::DISCOUNT_MONEY)
{
    if ($discount_type == \App\Model\Product::DISCOUNT_PERCENT || $discount < 100) {
        $discount = $discount . '% off';
    } else {
        switch (env('APP_CURRENCY', 'IDR')){
            case 'IDR':
                $discount = '- ' . number_format($discount, 0, '', '.') . ' Rp';
                break;
            case 'KRW':
                $discount = '- ' . number_format($discount, 0, '', '.') . ' KRW';
                break;
            default:
                $discount = '- ' . number_format($discount, 0, '', '.');
                break;
        }
    }
    return $discount;
}

function formatDiscountAmountForProductVariant($discount, $discountType)
{
    if ($discountType == \App\Model\ProductVariant::DISCOUNT_TYPE_PERCENT || $discount < 100) {
        $discount = $discount . '% off';
    } else {
        switch (env('APP_CURRENCY', 'IDR')){
            case 'IDR':
                $discount = '- ' . number_format($discount, 0, '', '.') . ' Rp';
                break;
            case 'KRW':
                $discount = '- ' . number_format($discount, 0, '', '.') . ' KRW';
                break;
            default:
                $discount = '- ' . number_format($discount, 0, '', '.');
                break;
        }
    }
    return $discount;
}

//Partially hide email address
function obfuscate_email($email)
{
    $em = explode("@", $email);
    $name = implode(array_slice($em, 0, count($em) - 1), '@');
    $len = floor(strlen($name) / 2);

    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}


function getListStoreType()
{
    return [
        \App\Model\Store::TYPE_NGO => 'NGO',
        \App\Model\Store::TYPE_INDIVIDUAL => 'Individual',
//        \App\Model\Store::TYPE_NGO => 'Small Medium Enterprise',
//        \App\Model\Store::TYPE_NGO => 'Big Companies',
    ];
}

function getListIndustry()
{
    return \App\Model\Industry::all()->pluck('name', 'id')->all();
}

function getListCategory2Levels()
{
    $categories = app('App\Service\CategoryService')->getListCategory2Levels();

    $categoryFlatArr = [];
    flatCategoryList($categories, 1, $categoryFlatArr);
    return $categoryFlatArr;
}

function getListCategory3Levels()
{
    $categories = app('App\Service\CategoryService')->getListCategory3Levels();

    $categoryFlatArr = [];
    flatCategoryList($categories, 1, $categoryFlatArr);

    return $categoryFlatArr;
}

function flatCategoryList($categories, $level, &$categoryFlatArr)
{
    foreach ($categories as $category) {

        $categoryFlatArr[] = [
            'id' => $category['id'],
            'name' => $category['name'],
            'slug' => $category['slug'],
            'level' => $level,
        ];

        if (isset($category['childrens'])) {
            flatCategoryList($category['childrens'], $level + 1, $categoryFlatArr);
        }
    }
}

function getListCategoryParent(){
    return \App\Model\Category::whereNull('parent_id')->get();
}

function getListPaymentMethod()
{
    return \App\Model\PaymentMethod::all()->pluck('name', 'id')->all();
}

function getListDeliveryUnit()
{
    return [
        1 => 'ShukShuk',
        2 => 'Anteraja'
    ];
    return \App\Model\DeliveryUnit::all()->pluck('name', 'id')->all();
}

function getListBankName(){
    $paymentService = new \App\Service\PaymentService();
    return $paymentService->getAvailableBanks();
}

/**
 * Get list of country
 *
 * @return array
 */
function getListCountry()
{
    // @todo: Replace to query from database.
    return [
        1 => 'Indonesia',
        2 => 'Korea',
        3 => 'Singapore',
        4 => 'Vietnam'
    ];
}

function toSlug($string)
{
    if ($string) {
        $arrUnicodeChars = array(
            "ạ",
            "á",
            "à",
            "ả",
            "ã",
            "Ạ",
            "Á",
            "À",
            "Ả",
            "Ã",
            "â",
            "ậ",
            "ấ",
            "ầ",
            "ẩ",
            "ẫ",
            "Â",
            "Ậ",
            "Ấ",
            "Ầ",
            "Ẩ",
            "Ẫ",
            "ă",
            "ặ",
            "ắ",
            "ằ",
            "ẳ",
            "ẫ",
            "ẵ",
            "Ă",
            "Ắ",
            "Ằ",
            "Ẳ",
            "Ẵ",
            "Ặ",
            "ê",
            "ẹ",
            "é",
            "è",
            "ẻ",
            "ẽ",
            "Ê",
            "Ẹ",
            "É",
            "È",
            "Ẻ",
            "Ẽ",
            "ế",
            "ề",
            "ể",
            "ễ",
            "ệ",
            "Ế",
            "Ề",
            "Ể",
            "Ễ",
            "Ệ",
            "ọ",
            "ộ",
            "ổ",
            "ỗ",
            "ố",
            "ồ",
            "Ọ",
            "Ộ",
            "Ổ",
            "Ỗ",
            "Ố",
            "Ồ",
            "Ô",
            "ô",
            "ó",
            "ò",
            "ỏ",
            "õ",
            "Ó",
            "Ò",
            "Ỏ",
            "Õ",
            "ơ",
            "ợ",
            "ớ",
            "ờ",
            "ở",
            "ỡ",
            "Ơ",
            "Ợ",
            "Ớ",
            "Ờ",
            "Ở",
            "Ỡ",
            "ụ",
            "ư",
            "ứ",
            "ừ",
            "ử",
            "ữ",
            "ự",
            "Ụ",
            "Ư",
            "Ứ",
            "Ừ",
            "Ử",
            "Ữ",
            "Ự",
            "ú",
            "ù",
            "ủ",
            "ũ",
            "Ú",
            "Ù",
            "Ủ",
            "Ũ",
            "ị",
            "í",
            "ì",
            "ỉ",
            "ĩ",
            "Ị",
            "Í",
            "Ì",
            "Ỉ",
            "Ĩ",
            "ỵ",
            "ý",
            "ỳ",
            "ỷ",
            "ỹ",
            "Ỵ",
            "Ý",
            "Ỳ",
            "Ỷ",
            "Ỹ",
            "đ",
            "Đ"
        );
        $arrNonUnicodeChars = array(
            "a",
            "a",
            "a",
            "a",
            "a",
            "A",
            "A",
            "A",
            "A",
            "A",
            "a",
            "a",
            "a",
            "a",
            "a",
            "a",
            "A",
            "A",
            "A",
            "A",
            "A",
            "A",
            "a",
            "a",
            "a",
            "a",
            "a",
            "a",
            "a",
            "A",
            "A",
            "A",
            "A",
            "A",
            "A",
            "e",
            "e",
            "e",
            "e",
            "e",
            "e",
            "E",
            "E",
            "E",
            "E",
            "E",
            "E",
            "e",
            "e",
            "e",
            "e",
            "e",
            "E",
            "E",
            "E",
            "E",
            "E",
            "o",
            "o",
            "o",
            "o",
            "o",
            "o",
            "O",
            "O",
            "O",
            "O",
            "O",
            "O",
            "O",
            "o",
            "o",
            "o",
            "o",
            "o",
            "O",
            "O",
            "O",
            "O",
            "o",
            "o",
            "o",
            "o",
            "o",
            "o",
            "O",
            "O",
            "O",
            "O",
            "O",
            "O",
            "u",
            "u",
            "u",
            "u",
            "u",
            "u",
            "u",
            "U",
            "U",
            "U",
            "U",
            "U",
            "U",
            "U",
            "u",
            "u",
            "u",
            "u",
            "U",
            "U",
            "U",
            "U",
            "i",
            "i",
            "i",
            "i",
            "i",
            "I",
            "I",
            "I",
            "I",
            "I",
            "y",
            "y",
            "y",
            "y",
            "y",
            "Y",
            "Y",
            "Y",
            "Y",
            "Y",
            "d",
            "D"
        );
        $arrSpecialChars = array(
            '!',
            '"',
            '#',
            '$',
            '%',
            '&',
            "'",
            '(',
            ')',
            '*',
            '+',
            ',',
            '-',
            '.',
            '/',
            ':',
            ';',
            '<',
            '=',
            '>',
            '?',
            '@',
            '[',
            '\\',
            ']',
            '^',
            '_',
            '`',
            '{',
            '|',
            '}',
            '~'
        );

        // Convert unicode->abc
        $string = str_replace($arrUnicodeChars, $arrNonUnicodeChars, $string);
        // Remove Non ASCII Characters
        $string = preg_replace("/[^(\x20-\x7F)]*/", '', $string);
        // Convert Special characters to space
        // Convert Special characters to space
        $string = str_replace($arrSpecialChars, ' ', $string);

        // Convert many spaces to space
        $string = preg_replace("/\s+/", ' ', $string);
        // Bỏ khỏang trắng hai đầu
        $string = trim($string);
        // Tạo kết nối giữa các từ bằng -
        $string = str_replace(' ', '-', $string);

        // Chuyển thành chữ thường
        $string = strtolower($string);

        return $string;
    }
    return '';
}

//get full name of user
function userFullName()
{
    $user = auth()->user();
    if ($user) {
        return $user->name . ' ' . $user->last_name;
    } else {
        return 'Please login';
    }
}

function getOrderId($order)
{
    return $order->id;
}

function getPaymentTypeTextFromStore($payment)
{
    // @todo: Get payment Type text
    switch ($payment->method){
        case 'CREDIT_CARD':
            return 'Paid with Credit Cards';
        case 'BANK_TRANSFER':
            return 'Paid with Bank Transfer';
        default:
            return '';
    }
}

function getStoreUrl($store)
{
    return route('store.index', ['slug' => $store->slug]);
}

function getProductImageUrl($path)
{
    return asset($path ? $path : '');
}

function getStoreAvatarUrl($path)
{
    return $path ? asset('/' . STORE_AVATAR_PATH . $path) : asset('img/store-avatar/default-avatar.png');
}

function getStoreAvatarUrlForSeller($path)
{
    return $path ? asset('/' . STORE_AVATAR_PATH . $path) : asset('img/store-avatar/default-avatar.png');
}

function getStoreProofImageUrl($path)
{
    if (!$path) {
        return '';
    }

    return '/img/store-cover/' . $path;
}

function getStoreCoverUrl($path)
{
    if (!$path) {
        return '';
    }

    return '/img/store-cover/' . $path;
}

function convertYoutube($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "https://www.youtube.com/embed/$2",
        $string
    );
}

function getStoreCoverUrlForSeller($path)
{
    if (!$path) {
//     return asset('placeholder/store-cover.png');
        return "";
    }

    return asset('/img/store-cover/' . $path);
}

function getUserAvatarUrl($path)
{
    // @todo: function
    return $path ? url('/img/store-avatar/' . $path) : '';
}

function getCurrentCurrencyCode()
{
    // @todo: Get from config
    return env('APP_CURRENCY', 'IDR');
}

function showStars($rating)
{
    for ($i = 0; $i <= $rating - 1; $i++) {
        echo('<img src="' . asset("vendor/buyer/Img/start.svg") . '" alt="">');
    }
    if ($rating - $i > 0) {
        echo('<img src="' . asset("vendor/buyer/Img/0.5-star.svg") . '">');
    }
}

function showDate($date)
{
    return date("d M Y", strtotime($date));
}

function stringNumberFormattedToInt($number, $decPoint = null)
{
    if (empty($decPoint)) {
        $locale = localeconv();
        $decPoint = $locale['decimal_point'];
    }

    return (int) str_replace($decPoint, '.', preg_replace('/[^\d' . preg_quote($decPoint) . ']/', '', $number));
}
function getProductInStoreByCategory($id){
    return App\Model\Category::with(['products'=> function($query) use ($id) {
        $query->where('store_id' , $id);
    }])
    ->whereHas('products', function ($query) use ($id) {
        $query->where('store_id' ,$id);
    })
        ->get();
}


// admin page

/*
 * Check store is active
 * products trading
 */

function checkStoreIsActive($storeId){
    $store = \App\Model\Store::where('id', $storeId)->first();
    if ($store->status == \App\Model\Store::STATUS_ACTIVE){
        return true;
    }
    return false;
}

/*
 * get string status of a store
 */

function stringStatusOfStore($storeStatus){
    switch ($storeStatus){
        case \App\Model\Store::STATUS_ACTIVE:
            return '<label class="label label-success">Active</label>';
        case \App\Model\Store::STATUS_DEACTIVE:
            return '<label class="label label-danger">Deactive</label>';
        case \App\Model\Store::STATUS_WAITING_APPROVAL:
            return '<label class="label label-warning">Wating Approval</label>';
        case \App\Model\Store::STATUS_DRAFT:
            return '<label class="label label-default">Draft</label>';
        default:
            return 'None';
    }
}

function getProvinces() {
    return \App\Model\AddressProvince::select('id', 'name')->get()->pluck('name', 'id')->toArray();
}

function clean($string) {
    $string = str_replace(' ', ' ', $string);
    $string = preg_replace('/[^A-Za-z0-9\-ığşçöüÖÇŞİıĞ]/', ' ', $string);

    return preg_replace('/-+/', '-', $string);
}

function cleanPhoneNum($phone){
    $phone = str_replace("-","",$phone);
    $phone = str_replace(" ", "", $phone);
    return $phone;
}

if (!function_exists('is_iterable')) {
    function is_iterable($obj) {
        return is_array($obj) || (is_object($obj) && ($obj instanceof \Traversable));
    }
}