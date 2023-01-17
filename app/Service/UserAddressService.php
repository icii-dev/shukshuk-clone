<?php

namespace App\Service;

use App\Model\AddressCity;
use App\Model\AddressDistrict;
use App\Model\Store;
use App\Model\User;
use App\Model\UserAddress;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class UserAddressService
{
    public function create(User $user, FormRequest $input)
    {
        $userAddress = new UserAddress();
        $userAddress->fill(
            $input->only(
                $userAddress->getFillable()
            )
        );

//        $districtId = 1101021;//$input->district_id
//        $district = AddressDistrict::
//            where('id', $districtId)
//            ->first();
//
//        if ($district) {
//            $userAddress->district_id = $districtId;
//            $userAddress->regency_id = object_get($userAddress, 'city.id', null);
//            $userAddress->province_id = object_get($userAddress, 'city.province.id', null);
//        }

        $userAddress->customer_id = $user->id;

        $userAddress->save();

        // Set as default
        $this->setAsDefault($userAddress);

        return $userAddress;
    }

    public function update(UserAddress $userAddress, FormRequest $input)
    {
        $userAddress->fill(
            $input->only(
                $userAddress->getFillable()
            )
        );

        $userAddress->save();
    }

    public function getById($id)
    {
        return UserAddress::find($id);
    }

    public function getDetail($id)
    {
        return UserAddress::with('province', 'city', 'district')
            ->where('id', $id)
            ->first();
    }

    public function setAsDefault(UserAddress $userAddress)
    {
        $customerId = $userAddress->customer_id;

        // Remove default others
        DB::table('user_address')
            ->where('customer_id', $customerId)
            ->update(['is_default' => 0]);

        // Set current as default
        DB::table('user_address')
            ->where('id', $userAddress->id)
            ->update(['is_default' => 1]);
    }

    public function getListAddressOfUser(User $user)
    {
        return UserAddress::where('customer_id', '=', $user->id)
            ->with('province', 'city', 'district')
            ->get();
    }

    public function delete(UserAddress $userAddress)
    {
        $userAddress->delete();
    }

    public function getDefaultOfUser(User $user)
    {
        $userAddress = UserAddress::where('customer_id', $user->id)
            ->where('is_default', 1)
            ->first();

        return $userAddress;
    }

    public function getLastUsedAddressForUser(User $user)
    {
        $userAddress = UserAddress::with('district')
            ->where('customer_id', $user->id)
            ->orderBy('id', 'DESC')
            ->first();

        return $userAddress;
    }

    public function getUserAddressByIdForUser($id, User $user)
    {
        $userAddress = UserAddress::with('district')
            ->where('customer_id', $user->id)
            ->where('id', $id)
            ->first();

        return $userAddress;
    }

    public function getListCityOption($provinceId)
    {
        $listCity = AddressCity::select('id', 'name')
            ->where('province_id', $provinceId)
            ->get();

        return $listCity;
    }

    public function getListDistrictOption($cityId)
    {
        $listDistrict = AddressDistrict::select('id', 'name')
            ->where('regency_id', $cityId)
            ->get();

        return $listDistrict;
    }
}
