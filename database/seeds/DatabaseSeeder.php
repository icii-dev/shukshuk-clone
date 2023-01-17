<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(PagesTableSeeder::class);
//
//        // Relation with store
//        $this->call(DeliveryUnitsTableSeeder::class);
//
//        // Seeder seller, store
//        $this->call(SellersTableSeeder::class);
//        $this->call(StoresTableSeeder::class);
//        $this->call(CategoryTableSeeder::class);
//        $this->call(CategoriesTableSeeder::class);
//        $this->call(ProductsTableSeeder::class);
//
//        $this->call(ComponentsTableSeeder::class);
//        $this->call(CouponsTableSeeder::class);
//        $this->call(OrdersTableSeeder::class);

        //execute Indonesia address
//        $path = 'database/indonesia_area.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('input indonesia_area!');

        $sqlFolder = __DIR__ . '/../sqls/';
        $sqlFiles = scandir($sqlFolder);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($sqlFiles as $sqlFile) {
            if (!strpos($sqlFile, '.sql')) {
//                $this->command->info('error!');
                continue;
                $this->call(SettingsTableSeeder::class);
    }
            try{
                DB::unprepared(file_get_contents($sqlFolder . $sqlFile));
                $this->command->info('success with' . $sqlFile);
            }catch (\Illuminate\Database\QueryException $ex){
                $this->command->error($ex->getMessage());
            }

        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
