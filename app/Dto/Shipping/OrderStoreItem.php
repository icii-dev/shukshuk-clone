<?php


namespace App\Dto\Shipping;


class OrderStoreItem
{
    public $id;
    public $name;
    public $ship_code;
    public $total_weight;
    public $subtotal;
    public $shipping_fee;
    public $total;
    public $products = [];
}
