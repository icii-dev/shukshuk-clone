<?php

use Illuminate\Database\Seeder;
use App\Model\Menu;
use App\Model\MenuItem;

class MenuItemsUpdateTableSeeder extends Seeder
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

            $menu = Menu::where('name', 'admin')->firstOrFail();
            $RefundMenuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Refund',
                'url'     => '/admin/refunds',
                'route'   => null,

            ]);
            if (!$RefundMenuItem->exists) {
                $RefundMenuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-dollar',
                    'color'      => '#000000',
                    'parent_id'  => $RefundMenuItem->id,
                    'order'      => 2,
                    'parameters'=>''
                ])->save();
            }

            $menu = Menu::where('name', 'admin')->firstOrFail();
            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Request Refund',
                'url'     => '/admin/refunds',
                'route'   => null,

            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => '#000000',
                    'parent_id'  => $RefundMenuItem->id,
                    'order'      => 2,
                    'parameters'=>'{"status":0}'
                ])->save();
            }

            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'title'   => 'Order Refund',
                'url'     => '/admin/order-refunds',
                'route'   => null,

            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => '#000000',
                    'parent_id'  => $RefundMenuItem->id,
                    'order'      => 2,
                    'parameters'=>''
                ])->save();
            }
        }
    }
}
