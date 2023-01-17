<?php

use Illuminate\Database\Seeder;

class DeliveryUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Model\DeliveryUnit();

        $model->id = 1;
        $model->name = 'Shukshuk delivery';

        $model->save();
    }
}