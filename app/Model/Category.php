<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $guarded = [];

    protected $table = 'categories';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->childrens()->with('childrenRecursive');
    }
}
