<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Requests\Buyer\UpdateUserRequest;
use App\Model\AddressProvince;
use App\Service\UserAddressService;
use ErrorException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;
use App\Model\UserAddress;

use App\Service\UserService;


class UsersController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();
        $userAddress = new UserAddress();
        if($user->address){
            $userAddress = $user->address;
        }
        $provinces = AddressProvince::with('cities')->get();

        $this->seo()->setTitle(
            trans('user.my_profile_title', [])
        );
        $this->seo()->setDescription(
            trans('user.my_profile_description', [])
        );
        if(is_mobile()){
            return view('buyer.mobile.my-profile')->with([
                'user' => $user,
                'userAddress' => $userAddress,
                'provinces' => $provinces,
            ]);
        }
        return view('buyer.my-profile')->with([
            'user' => $user,
            'userAddress' => $userAddress,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, UserService $userService, UserAddressService $userAddressService)
    {
        $user = auth()->user();

        $userService->update($user, $request);
        //save user address
        $userAddressService->update(UserAddress::firstOrNew(['customer_id' => $user->id]), $request);

        return back()->with('success_message', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
