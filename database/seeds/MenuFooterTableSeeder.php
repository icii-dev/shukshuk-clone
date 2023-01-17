<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Model\Menu;
use App\Model\MenuItem;

class MenuFooterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(base_path('routes/web.php'))) {
            require base_path('routes/web.php');

            /*
            |--------------------------------------------------------------------------
            | About in Main Menu
            |--------------------------------------------------------------------------
            */

            $menu = Menu::where('name', 'footer')->firstOrFail();

            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Shukshuk',
                'url'     => Str::slug('Shukshuk', '-'),
                'route'   => null,
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => null,
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 2,
                ])->save();
            }
//            sleep(1);
                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'About Us',
                        'url'     => Str::slug('About Us', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }
                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Terms & Conditions',
                        'url'     => Str::slug('Terms & Conditions', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }
                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Privacy Policy',
                        'url'     => Str::slug('Privacy Policy', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }
                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Legal',
                        'url'     => Str::slug('Legal', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

            ////end Shukshuk

            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Seller',
                'url'     => Str::slug('Seller', '-'),
                'route'   => null,
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => null,
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 2,
                ])->save();

            }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Register as Seller',
                        'url'     => Str::slug('Register as Seller', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Store Tour',
                        'url'     => Str::slug('Store Tour', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Selling 101',
                        'url'     => Str::slug('Selling 101', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

            //end seller

            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Buyer',
                'url'     => Str::slug('Buyer', '-'),
                'route'   => null,
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => null,
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 2,
                ])->save();
            }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Shopping Tutorial',
                        'url'     => Str::slug('Shopping Tutorial', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Payment Methods',
                        'url'     => Str::slug('Payment Methods', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }

                    //children Item
                    $menuItemChildren = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'title'   => 'Refund Policy',
                        'url'     => Str::slug('Refund Policy', '-'),
                        'route'   => null,
                    ]);
                    if (!$menuItemChildren->exists) {
                        $menuItemChildren->fill([
                            'target'     => '_self',
                            'icon_class' => null,
                            'color'      => null,
                            'parent_id'  => $menuItem->id,
                            'order'      => 2,
                        ])->save();
                    }


        }
    }
}
