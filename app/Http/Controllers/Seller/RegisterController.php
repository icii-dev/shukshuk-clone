<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;
use App\Http\Requests\Seller\RegisterStep1Request;
use App\Http\Requests\Seller\RegisterStep2Request;
use App\Http\Requests\Seller\RegisterStep3Request;
use App\Model\AddressProvince;
use App\Model\Seller;
use App\Model\Store;
use App\Model\User;
use App\Service\SellerService;
use App\Service\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends SellerController
{
    /**
     * @var StoreService
     */
    private $storeService;

    /**
     * @var SellerService
     */
    private $sellerService;

    public function __construct(
        StoreService $storeService,
        SellerService $sellerService
    ) {
        $this->storeService = $storeService;
        $this->sellerService = $sellerService;
    }

    public function register(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->seller && $user->seller->register_completed_step) {
            return redirect(
                route('seller.register.step_' . ($user->seller->register_completed_step + 1))
            );
        }

        return redirect(
            route('seller.register.step_1')
        );
    }

    public function step1(Request $request)
    {
        $seller = auth()->user()->seller;

        return view('seller.register.step_1', [
            'step'   => 1,
            'seller' => $seller
        ]);
    }

    public function step2(Request $request)
    {
        $this->backToRightStepIfCurrentStepInvalid(2);

        /** @var Store $store */
        $store = auth()->user()->store;

        $provinces = AddressProvince::all();
        return view('seller.register.step_2', [
            'step'      => 2,
            'store'     => $store,
            'provinces' => $provinces,
        ]);
    }

    public function step3(Request $request)
    {
        $this->backToRightStepIfCurrentStepInvalid(2);

        /** @var Store $store */
        $store = auth()->user()->store;

        return view('seller.register.step_3', [
            'step'  => 3,
            'store' => $store
        ]);
    }

    /**
     * Post save seller information
     */
    public function postStep1(RegisterStep1Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        // Validate image
        if (!$seller = $user->seller) {

            $validator = Validator::make($request->all(), [
                'proof_image_upload' => 'required|mimes:jpg,jpeg,png|max:10240',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            $validator = Validator::make($request->all(), [
                'proof_image_upload' => 'nullable|mimes:jpg,jpeg,png|max:10240',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // Save seller information
        if ($seller) {
            $this->sellerService->update($seller, $request);
        } else {
            $seller = $this->sellerService->create($user, $request);
        }

        $seller->register_completed_step = 1;
        $seller->save();

        // Go to step 2
        return redirect(
            route('seller.register.step_2')
        );
    }

    /**
     * Post save store information
     */
    public function postStep2(RegisterStep2Request $request)
    {
        $this->backToRightStepIfCurrentStepInvalid(2);

        /** @var User $user */
        $seller = auth()->user()->seller;

        // Validate
        if (!$store = auth()->user()->store) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                => 'required|unique:stores,name',
                    'proof_image_upload'  => 'nullable|mimes:jpg,jpeg,png|max:10240',
                    'avatar_image_upload' => 'nullable|mimes:jpg,jpeg,png|max:10240',
                    'address_province_id' => 'required',
                    'address_city_id'     => 'required',
                    'address_district_id' => 'required',
                    'address'             => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->route('seller.register.step_2')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'                => [
                        Rule::unique('stores', 'name')->ignore($store->id),
                    ],
                    'proof_image_upload'  => 'nullable|mimes:jpg,jpeg,png|max:10240',
                    'avatar_image_upload' => 'nullable|mimes:jpg,jpeg,png|max:10240'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // Save store
        if ($store) {
            $this->storeService->update($store, $request);
        } else {
            $this->storeService->create($seller, $request);
        }

        //event when seller registered
        event(new \App\Events\SellerRegistered($seller));

        // Save register step
        $seller->register_completed_step = 2;
        $seller->save();

        // Go to step 3
        return redirect(
            route('seller.register.step_3')
        );
    }

    public function postStep3(RegisterStep3Request $request)
    {
        $this->backToRightStepIfCurrentStepInvalid(2);

        $user = auth()->user();
        $store = $user->store;

        // Save store
        $this->storeService->update($store, $request);
        $store->status = Store::STATUS_WAITING_APPROVAL;
        $store->save();

        // Save bank store
        $this->storeService->createBank($user->store, $request);

        $seller = auth()->user()->seller;

        // Save register step
        $seller->register_completed_step = 2;
        $seller->save();

        // Update seller status
        $seller->status = Seller::STATUS_ACTIVE;
        $seller->save();

        // Clean session
        $request->session()->remove('register_store_step');

        // Go to dashboard page
        return redirect(
            route('seller.home')
        )->with('message', __('Your store is waiting for approval. Feel free to create products'));
    }

    private function backToRightStepIfCurrentStepInvalid($currentStep)
    {
        $seller = auth()->user()->seller;

        if ($currentStep > ($seller->register_completed_step + 1)) {
            redirect(
                route('seller.register.step_' . $seller->register_completed_step)
            );
            die;
        }
    }
}
