<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\CreateUserAddressRequest;
use App\Http\Requests\Buyer\UpdateUserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Service\ProductService;
use App\Service\ShipmentService;
use App\Service\UserAddressService;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAddressController extends Controller
{
    /**
     * @var UserAddressService
     */
    private $userAddressService;

    public function __construct(
        UserAddressService $userAddressService
    ) {
        $this->userAddressService = $userAddressService;
    }

    public function getList()
    {
        $user = auth()->user();
        $userAddresses = $this->userAddressService->getListAddressOfUser($user);

        return response()->json($userAddresses);
    }

    public function show($id){
        $userAddress = $this->userAddressService->getUserAddressByIdForUser($id, auth()->user());
//        return dd($userAddress->province->name);
        return new UserAddressResource($userAddress);
//        return response()->json($userAddress);
    }

    public function create(CreateUserAddressRequest $input)
    {
        $user = auth()->user();
        $userAddress = $this->userAddressService->create($user, $input);

        return response()->json($this->userAddressService->getDetail($userAddress->id), Response::HTTP_CREATED);
    }

    public function update($id, UpdateUserAddressRequest $input)
    {
        $userAddress = $this->userAddressService->getById($id);

        if (!$userAddress || $userAddress->customer_id !== auth()->user()->id) {
            abort(404, 'The address does not exist');
        }

        $this->userAddressService->update($userAddress, $input);

        return response()->json($userAddress);
    }

    public function delete($id)
    {
        $userAddress = $this->userAddressService->getById($id);

        if (!$userAddress || $userAddress->customer_id !== auth()->user()->id) {
            abort(404, 'The address does not exist');
        }

        $this->userAddressService->delete($userAddress);

        return response()->json([
            'success' => 1
        ]);
    }

    public function setDefault($id)
    {
        $userAddress = $this->userAddressService->getById($id);

        if (!$userAddress || $userAddress->customer_id !== auth()->user()->id) {
            abort(404, 'The address does not exist');
        }

        $this->userAddressService->setAsDefault($userAddress);

        return response()->json($userAddress);
    }

//    public function getCart(ProductService $productService)
//    {
//        $cart = Cart::instance('shopping');// @todo: shopping or Buynow
//
//        $ids = $cart->content()->map(function ($item) {
//            return $item->id;
//        });
//
//        $stores = [];
//        $storeCollection = Collection::make();
//        $productCollection = empty($ids) ? Collection::make([]) : $productService->getProductByIds($ids);
//
//        // Cart group by store
////        foreach ($cart->content() as $cartKey => $cartItem) {
////            $storeId = $cartItem->options->store_id;
////
////            if (!$storeCollection->has($storeId)) {
////                $storeCollection->put($storeId, [
////                    'id' => $storeId,
////                    'name' => '',
////                    'items' => []
////                ]);
////            }
////
////            dd($storeCollection->get($storeId));
////
////            $storeCollection->get($storeId)['items'][] = 'hai';
////
//////            dd($storeCollection->get($storeId)['items'][] = 'hai');
////            dd($storeCollection->get($storeId));
////
////        }
//
//        /**
//         * @var string $cartKey
//         * @var CartItem $cartItem
//         */
//        foreach ($cart->content() as $cartKey => $cartItem) {
//            $storeId = $cartItem->options->store_id;
//
//            if (!array_key_exists($storeId, $stores)) {
//                $stores[$storeId] = [
//                    'id' => $storeId,
//                    'name' => '',// @todo
//                    'shipping_fee' => [],
//                    'items' => []
//                ];
//            }
//
//            $product = $productCollection->find($cartItem->id);
//
//            $productChecked = [];
//            $productChecked['id'] = $cartItem->id;
//            $productChecked['name'] = $cartItem->name;
//            $productChecked['qty'] = $cartItem->qty;
//            $productChecked['price'] = $cartItem->price;
//            $productChecked['options'] = $cartItem->options;
//
//            $stores[$storeId]['items'][] = $productChecked;
//        }
//
//        // Snap store
//        session()->put('checkout', $stores);
//
//        return response()->json($stores);
//    }

//    public function findShippingOptions(
//        Request $request,
//        UserAddressService $userAddressService,
//        ShipmentService $shipmentService
//    ) {
//        $user = auth()->user();
//        $store = $request->get('store_id');
//
//        // Get default user address
//        $userAddress = session()->get('checkout.user_address', null);
//
//        if (!$userAddress) {
//            $userAddress = $userAddressService->getDefaultOfUser($user);
//        }
//
//
//        $origin = '31.71.01';// @todo: dynamic this param
//        $destination = '75.71.06';
//
//        $shipmentService->findOptions($origin, $destination);
//    }
//
//    public function order()
//    {
//
//    }
}
