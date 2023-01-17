<?php

use Illuminate\Database\Seeder;
use App\Model\Menu;

class MenusTableSeederCustom extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'main',
        ]);

        Menu::firstOrCreate([
            'name' => 'footer',
        ]);
    }
}
