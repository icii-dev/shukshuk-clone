<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Resources\SearchProductInStoreResource;
use App\Model\Store;
use App\Service\SearchService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function search(Request $request, SearchService $searchService)
    {
        $request->validate([
            'keyword' => 'required',
        ]);

        $page = ($request->input('page'))?$request->input('page'):1;
        $keyword = $request->input('keyword');
        $products = $searchService->searchProductsByKeyword($keyword, $page);

        $stores = Store::where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->published()
            ->get();

        if (request()->ajax()) {
            return $products;
        }

        $this->seo()->setTitle(
            trans('search.title', ['keyword' => $keyword])
        );

        $this->seo()->setDescription(
            trans('search.description', ['keyword' => $keyword])
        );

        return view('buyer.search-results')
            ->with([
                'products' => $products,
                'stores' => $stores
            ]);
    }

    /**
     * @param Request $request
     * @param SearchService $searchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickSearch(Request $request, SearchService $searchService){
        $request->validate([
            'query' => 'required',
        ]);

        $query = $request->input('query');
        $data = array();

        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('details', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->published()
            ->select(['name', 'slug'])
            ->limit(3)
            ->get();
        foreach ($products as $product){
            $product->desc = "Product";
            array_push($data, $product);
        }

        $store = Store::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->published()
            ->first();
        if($store){
            $store->desc = "Store";
            array_push($data, $store);
        }

        return response()->json($data, Response::HTTP_OK);
    }

    public function quickSearchInStore($storeId, Request $request){
        $request->validate([
            'query' => 'required',
        ]);
        $query = $request->input('query');
        $products = Product::where('store_id', $storeId)
            ->where('name', 'like', "%$query%")
            ->select('name', 'slug', 'status', 'id')
            ->published()
            ->get();
        return SearchProductInStoreResource::collection($products);
    }
}
