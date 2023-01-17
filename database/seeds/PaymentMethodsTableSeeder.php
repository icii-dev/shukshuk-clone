<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'id' => 1,
                'name' => 'Bank transfer (Virtual Account)',
            ],
            [
                'id' => 2,
                'name' => 'Credit card (Visa, Master)'
            ],
            [
                'id' => 3,
                'name' => 'E-wallet (OVO)'
            ]
        ];

        foreach ($rows as $row) {
            $paymentMethod = new \App\Model\PaymentMethod();
            $paymentMethod->id = $row['id'];
            $paymentMethod->name = $row['name'];

            $paymentMethod->save();
        }
    }
}
