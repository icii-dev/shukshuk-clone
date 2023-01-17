<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
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
                'name' => 'Industry 01',
            ],
            [
                'name' => 'Industry 02',
            ]
        ];

        foreach ($rows as $row) {
            \App\Model\Industry::create($row);
        }
    }
}
