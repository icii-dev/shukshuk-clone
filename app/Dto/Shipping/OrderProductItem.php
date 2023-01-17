<?php


namespace App\Dto\Shipping;


class OrderProductItem
{
    public $id;
    public $name;
    public $quantity;
    public $price;
    public $stock;
    public $weight;
    public $note;
    public $options = [];
}
