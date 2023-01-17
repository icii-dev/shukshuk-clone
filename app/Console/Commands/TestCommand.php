<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $districts = \DB::table('kanteraja_district_all')->get();
//
//        foreach ($districts as $district) {
//            list($province, $city, $districtId) = explode('.', $district->district_code);
//
//            \DB::table('kanteraja_district_all')
//                ->where('id', $district->id)
//                ->update([
//                    'province_id' => $province,
//                    'city_id' => $city,
//                    'district_id' => $districtId
//                ]);
//        }die;

//        $results = \DB::table('kanteraja_district_all')
//            ->select(['province_id', 'province'])
//            ->groupBy(['province_id', 'province'])
//            ->get()
//        ;
//
//        $i = 1;
//        foreach ($results as $result) {
//            \DB::table('address_provinces_indo')
//                ->insert([
//                    'id' => $i++,
//                    'name' => $result->province,
//                    'tmpid' => $result->province_id
//                ]);
//        }

//        $results = \DB::select('
//select a.*
//from kanteraja_district_all a
//join (
//select *
//from kanteraja_district_all
//group by city_id, province_id
//'));


        $i = 1;
        $results = \DB::table('kanteraja_district_all')
            ->select(['province_id', 'city_id', 'district_id', 'district'])
            ->groupBy(['province_id', 'city_id', 'district_id', 'district'])
            ->get()
        ;

        $i = 1;
        foreach ($results as $result) {
            $cityId = $result->province_id . '.' . $result->city_id;
            $citys = \DB::select('select * from address_regencies_indo where tmpid = "' . $cityId . '"');
            $city = $citys[0];

            \DB::table('address_districts_indo')
                ->insert([
                    'id' => $i++,
                    'regency_id' => $city->id,
                    'name' => $result->district,
                    'ship_code' => $result->province_id . '.' . $result->city_id . '.' . $result->district_id,
                    'tmpid' => $result->province_id . '.' . $result->city_id . '.' . $result->district_id
                ]);
        }



//        $districts = \App\Model\AddressDistrict::where('slug', null)->get();
//
//        foreach($districts as $district) {
//            $district->slug = toSlug($district->name);
//            $district->save();
//        }
    }
}
