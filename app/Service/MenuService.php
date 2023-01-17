<?php
namespace App\Service;

use App;

class MenuService {
    function getFooterParent(){
        $menu = \TCG\Voyager\Models\Menu::where('name', 'footer')->firstOrFail();
        return $menuItems = \TCG\Voyager\Models\MenuItem::where([
            'menu_id' => $menu->id,
            'parent_id' => null
            ])->get();
    }

    public function getFooter(){
        $lang = App::getLocale();
        $menu = \TCG\Voyager\Models\Menu::where('name', 'footer')->firstOrFail();
        return $menuItems = \TCG\Voyager\Models\MenuItem::where([
            'menu_id' => $menu->id,
        ])
            ->get()
            ->translate($lang, 'en');
    }
}