<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\CreateUserAddressRequest;
use App\Http\Requests\Buyer\UpdateUserAddressRequest;
use App\Model\UserAddress;
use App\Service\ProductService;
use App\Service\ShipmentService;
use App\Service\UserAddressService;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;

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

    public function create(CreateUserAddressRequest $input)
    {
        $user = auth()->user();
        $userAddress = $this->userAddressService->create($user, $input);

        $html = view('buyer.user_address._address_item', $userAddress)->render();

        return response()->json([
            'success' => 1,
            'html' => $html
        ]);
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

        return response()->json([
            'success' => 1
        ]);
    }
}
