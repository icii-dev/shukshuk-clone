<?php

namespace App\Http\Controllers\Buyer;

use App;
use App\Http\Controllers\Controller;
use App\Service\ProductService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return array
     */
    public function index(ProductService $productService, App\Service\StoreService $storeService)
    {
        $lang = App::getLocale();

        $page = (request()->page) ? request()->page : 1;
        $featureProducts = $productService->getPagedFeatured($page, 10);
        if (request()->ajax()) {
            $data = '';
            foreach ($featureProducts as $product){
                $data .= View('buyer.partials.product.item-product-list', ['product'=>$product])->render();
            }
            return response()->json([
                'html' => $data
            ]);
        }

        $storesOfCate1 = $storeService->get3StoresOfParentCategory(1);
        $storesOfCate2 = $storeService->get3StoresOfParentCategory(111);
        $storesOfCate3 = $storeService->get3StoresOfParentCategory(86);

        $featureStores = $storeService->getFeaturedStores();

        $this->seo()->setTitle(
            trans('home.title'),
            false
        );
        $this->seo()->setDescription(
            trans('home.description')
        );
        return view('buyer.home')->with([
            'featureProducts' => $featureProducts,
            'storesOfCate1' => $storesOfCate1,
            'storesOfCate2' => $storesOfCate2,
            'storesOfCate3' => $storesOfCate3,
            'featureStores' => $featureStores
        ]);
    }
}
