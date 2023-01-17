<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Resources\ProductCollection;
use App\Model\Category;
use App\Model\WishlistStore;
use App\Service\SearchService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Model\Store;

use App\Service\StoreService;
use App\Service\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Array_;

class StoreController extends Controller
{

    function index($slug, ProductService $productService){
        $page = (request()->page)?request()->page:1;

        $qb = Store::with('products')
            ->where('slug', $slug)
            ->where('status', '=', Store::STATUS_ACTIVE);

        // Allow owner store, can preview their store
        if (auth()->user() && Route::currentRouteName() == 'store.preview.index') {
            $qb->orWhere('user_id', auth()->user()->id);
        }

        $store = $qb->firstOrFail();
//        $store->recalculateRating();
        // get all products PUBLISHED
        $products = $productService->getProductOfStore($store->id, $page);
        $cate= $productService->getProductInStoreByCategory($store->id);

        if (request()->ajax()) {
            return $products;
        }

        //check user has wishlist
        if(auth()->user()){
            $wishlist = WishlistStore::where([
                'store_id' => $store->id,
                'user_id' => Auth::user()->id,
            ])->first();
            $isWishlist = $wishlist?true:false;
        }else{
            $isWishlist = false;
        }

        $this->seo()->setTitle(
            trans('product.title', ['name' => $store->name])
        );
        $this->seo()->setDescription(
            trans('product.description', ['name' => $store->name])
        );
        if(is_mobile()){
            return view('buyer.mobile.store')->with([
                'store' => $store,
                'products' => $products,
                'isWishlist' => $isWishlist,
            ]);
        }
        return view('buyer.store')->with([
            'store' => $store,
            'products' => $products,
            'isWishlist' => $isWishlist,
            'cate' =>$cate
        ]);
    }

    function searchProducts(Request $request, SearchService $searchService){
        $request->validate([
            'idStore' => 'required',
            'keyword' => 'required',
        ]);

        $page = ($request->input('page'))?$request->input('page'):1;

        $keyword = $request->input('keyword');
        $idStore = $request->input('idStore');
        $products = $searchService->searchProductsInStore($idStore, $keyword, $page);

        if (request()->ajax()) {
            $productHtmls = [];

            foreach ($products as $product) {
                $productHtmls[] = \view('buyer.partials.product.item-product-list', [
                    'product' => $product
                ])->render();
            }

            return \response()->json([
                'html' => implode('', $productHtmls)
            ]);
//            return response()->json($products, Response::HTTP_OK);
        }
        return view('buyer.store')->with('products', $products);
    }

    public function sellerCategory($type, $category_slug, $sub_cat, $rating, StoreService $storeService){
        $page = (request()->page)?request()->page:1;
        if($category_slug == '0'){
            $stores = $storeService->getListStoreBySlugType($type);
        }else{
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $stores = $storeService->getListStoreBySlugTypeAndCatAndRating($type, $category, $rating, $page);
            if (request()->ajax()) {
                return response()->json($stores, Response::HTTP_OK);
            }
        }

        $featuredStore = array();
        foreach ($stores as $store){
            if($store->featured == Store::FEATURED_ON){
                array_push($featuredStore, $store);
            }

        }

        if (request()->ajax()) {
            return $stores;
        }

        $typeName =  trans('category.seller_type.' . $type);
        $this->seo()->setTitle(
            trans('category.seller_title', ['name' => $typeName])
        );
        $this->seo()->setDescription(
            trans('category.seller_description', ['name' => $typeName])
        );

        return view('buyer.seller-category')->with([
            'type' => $type,
            'stores' => $stores,
            'featuredStore' => $featuredStore,
        ]);
    }
    function searchProductsByCategory(Request $request, SearchService $searchService){
        $request->validate([
            'idStore' => 'required',
            'keyword' => 'required',
            'idCategory'=>'required'
        ]);

        $page = ($request->input('page'))?$request->input('page'):1;

        $keyword = $request->input('keyword');
        $idCategory = $request->input('idCategory');
        $idStore =$request->input('idStore');
        $products = $searchService->searchProductsInStoreByCategory($idStore,$idCategory,$keyword, $page);

        if (request()->ajax()) {
            $productHtmls = [];

            foreach ($products as $product) {
                $productHtmls[] = \view('buyer.partials.product.item-product-list', [
                    'product' => $product
                ])->render();
            }

            return \response()->json([
                'html' => implode('', $productHtmls)
            ]);
//            return response()->json($products, Response::HTTP_OK);
        }
        return view('buyer.store')->with('products', $products);
    }
}
