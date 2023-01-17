<?php

namespace App\Http\Controllers\Api;

use App\Model\AddressCity;
use App\Model\AddressDistrict;
use App\Model\AddressProvince;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function getListProvinceOption()
    {
        $listProvince = AddressProvince::select('id', 'name')
            ->get();

        return $listProvince;
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

    public function cities($province_id){
       $cities = AddressCity::where('province_id', $province_id)->get();
        return response()->json($cities, Response::HTTP_OK);
    }

    public function districts($city_id){
        $district = AddressDistrict::where('regency_id', $city_id)->get();
        return response()->json($district, Response::HTTP_OK);
    }
}
