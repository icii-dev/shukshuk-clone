<?php

use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('
                INSERT INTO `sellers`(`id`, `user_id`, `first_name`, `last_name`, `email`, `dob`, `phone`, `nationality_id`, `residence_id`, `id_number`, `proof_image`, `status`, `created_at`, `updated_at`) VALUES (1, 25, \'Tin\', \'Tran\', \'cau2binhdinh@gmail.com\', NULL, \'0933652114\', 1, 1, \'2312321321\', NULL, NULL, \'2020-02-01 14:50:50\', \'2020-02-01 14:50:50\');

        ');
    }
}
