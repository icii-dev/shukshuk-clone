<?php

namespace App\Service;

use App\Http\Resources\ProductCollection;
use App\Model\Product;

use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class SearchService
{
    public function searchProductsByKeyword($keyword, $page = 1, $limit = 20)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product::with('store')
            ->where('name', 'like', "%$keyword%")
            ->orWhere('details', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->published()
            ->paginate($limit);

        return new ProductCollection($products);
    }

    public function searchProductsInStore($idStore, $keyword, $page = 1, $limit = 20)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product::with('store')
            ->where('store_id', $idStore)
            ->where(function ($query) use ($keyword) {
                $query->where('status', '=', Product::STATUS_ACTIVE)
                    ->where('name', 'like', "%$keyword%")
                    ->orWhere('details', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            })

            ->paginate($limit);

        return $products;
    }
    public function searchProductsInStoreByCategory($idStore,$idCategory,$keyword, $page = 1, $limit = 20)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product::with(['categories'=> function($query)use ($idCategory){
            $query->where('category_id',$idCategory);
        }])
            ->whereHas('categories',function ($query)use ($idCategory){
                $query->where('category_id',$idCategory);
            })
            ->where('store_id',$idStore)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('details', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%");
            })

            ->paginate($limit);

        return $products;
    }
}