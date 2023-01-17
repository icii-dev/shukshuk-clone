<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;
use App\Http\Requests\Seller\UpdateStoreRequest;
use App\Model\AddressProvince;
use App\Model\Store;
use App\Service\SearchService;
use App\Service\StoreService;
use App\Service\UserAddressService;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends SellerController
{
    public function edit(UserAddressService $userAddressService)
    {
        $store = auth()->user()->store;
        $provinces = AddressProvince::all();
        $storeProvince=$store->province;
        $storeCity=$store->city;
        $storeDistrict=$store->district;

        //get list district, city in province of store
        $listCityDefault = $userAddressService->getListCityOption($storeProvince->id);
        $listDistrictDefault = $userAddressService->getListDistrictOption($storeCity->id);

        $this->seo()->setTitle('Edit store');

//        return view('seller.store.edit', compact('store'));
        return view('seller.store.edit', [
            'store' => $store,
            'provinces' => $provinces,
            'storeProvince' => $storeProvince,
            'storeCity' => $storeCity,
            'storeDistrict' => $storeDistrict,
            'listCityDefault' => $listCityDefault,
            'listDistrictDefault' => $listDistrictDefault,
        ]);
    }

    public function store(UpdateStoreRequest $request, StoreService $storeService)
    {
        $store = auth()->user()->store;
        $storeService->update($store, $request);

        return redirect()->back()->with('success', 'The store updated successfully');
    }

    public function updateAvatar(Request $request, StoreService $storeService)
    {
        /** @var Store $store */
        $store = auth()->user()->store;

        if ($request->isXmlHttpRequest() && $request->get('image')) {
            $storeService->updateAvatarImageFromBase64($store, $request->get('image'));
        }

        return response()->json([
            'url' => getStoreAvatarUrlForSeller($store->avatar_image)
        ]);

    }

    public function updateCover(Request $request, StoreService $storeService)
    {
        /** @var Store $store */
        $store = auth()->user()->store;

        if ($request->isXmlHttpRequest() && $request->get('image')) {
            $storeService->updateCoverImageFromBase64($store, $request->get('image'));
        }

        return response()->json([
            'url' => getStoreCoverUrlForSeller($store->cover_image)
        ]);
    }
    function searchProducts(\Illuminate\Http\Request $request, SearchService $searchService){
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
                $productHtmls[] = \view('seller.partials.item-product-list-in-store', [
                    'product' => $product
                ])->render();
            }

            return \response()->json([
                'html' => implode('', $productHtmls)
            ]);
        }
        return view('seller.product.index')->with('products', $products);
    }
}
