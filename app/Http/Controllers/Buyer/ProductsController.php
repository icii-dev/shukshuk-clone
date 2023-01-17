<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Model\AddressDistrict;
use App\Model\Category;
use App\Model\Product;
use App\Model\Store;
use App\Model\Wishlist;

use App\Service\AnterajaService;
use App\Service\ProductService;
use App\Service\ShippingService;
use App\Service\UserAddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show($slug, ProductService $productService)
    {
        $product = $productService->getPublishedBySlug($slug);

        //update rating of product
//        $product->recalculateRating();
        //Percentage of ratings product
        $percentageOfRatings = $productService->percentageOfRatings($product->reviews);

        // products also like
        $mightAlsoLike = $productService->getPagedRelated($product->id, 1, 5);

        //check user has wishlish
        if(auth()->user()){
            $wishlist = Wishlist::where([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
            ])->first();
            $isWishlist = $wishlist?true:false;
        }else{
            $isWishlist = false;
        }

        $this->seo()->setTitle(
            trans('product.title', ['name' => $product->name])
        );
        $this->seo()->setDescription(
           trans('product.description', ['name' => $product->name])
        );

        if(is_mobile()){
            return view('buyer.mobile.product')->with([
                'product' => $product,
                'isWishlist' => $isWishlist,
                'mightAlsoLike' => $mightAlsoLike,
                'percentageOfRatings' => $percentageOfRatings,
            ]);
        }

        return view('buyer.product')->with([
            'product' => $product,
            'isWishlist' => $isWishlist,
            'mightAlsoLike' => $mightAlsoLike,
            'percentageOfRatings' => $percentageOfRatings,
        ]);
    }

    /**
     * For Admin review all product (active and deactive)
     * @param $slug
     * @param ProductService $productService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($slug, ProductService $productService)
    {
        $product = $product = Product::with('options', 'options.values')
            ->where('slug', 'like', $slug)
            ->firstOrFail();
        $stockLevel = getStockLevel($product->quantity);

        //update rating of product
//        $product->recalculateRating();
        //Percentage of ratings product
        $percentageOfRatings = $productService->percentageOfRatings($product->reviews);

        // products also like
        $mightAlsoLike = $productService->getPagedRelated($product->id, 1, 5);

        //check user has wishlish
        if(auth()->user()){
            $wishlist = Wishlist::where([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
            ])->first();
            $isWishlist = $wishlist?true:false;
        }else{
            $isWishlist = false;
        }
        return view('buyer.product')->with([
            'product' => $product,
            'isWishlist' => $isWishlist,
            'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
            'percentageOfRatings' => $percentageOfRatings,
        ]);
    }

    public function category($category_slug, $sub_cat, $rating, ProductService $productService){
        $category = Category::where('slug', $category_slug)->firstOrFail();
        $page = (request()->page)?request()->page:1;
        $products = $productService->getProductByCategoryAndRating($category, $rating, $page);
        if (request()->ajax()) {
            return $products;
        }

        $this->seo()->setTitle(
            trans('category.product_title', ['name' => $category->name])
        );
        $this->seo()->setDescription(
            trans('category.product_description', ['name' => $category->name])
        );

        return view('buyer.product-category')->with([
            'category' => $category,
            'products' => $products,
            '$old_cat_slug' => $category_slug,
        ]);
    }

    /** get the reviews has been paginated
     * @param $productID
     * @param ProductService $productService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reviewsPagination($productID, ProductService $productService){
        $page = (request()->page)?request()->page:1;
        $product = Product::find($productID);
        $reviews = $productService->getReviewsPagination($product, $page);
        return view('buyer.partials.response.reviews-list')->with([
           'reviews' => $reviews,
        ]);
    }

    public function getShippingFee(Request $request, UserAddressService $addressService, ShippingService $shippingService){
        $user = auth()->user();
        if(!$user){
            $buyerDistrict = 2034;
        }else{
            $buyerDistrict = $addressService->getDefaultOfUser($user)->district_id;
        }
        $storeId = $request->storeId;
        $weight = $request->weight;
        $store = Store::where('id', $storeId)->firstOrFail('address_district_id');
        $originId = $store->district->ship_code;
        $destination = AddressDistrict::findOrFail($buyerDistrict);
        $destinationId = $destination->ship_code;
        $options = $shippingService->findOptions($originId, $destinationId, $weight);
        $cost = $options[0]->cost;
        foreach ($options as $option){
            $cost = min($cost, $option->cost);
        }
        return \response([
            'fee' => moneyFormat($cost),
            'districtName' => strtoupper($destination->name)
        ]);
    }
}
