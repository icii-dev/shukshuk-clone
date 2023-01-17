<?php


namespace App\Http\View\Composers;

use App\Service\MenuService;
use Illuminate\Contracts\View\View;


class BuyerMenuFooterComposer
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {

        $this->menuService = $menuService;
    }

    public function compose(View $view)
    {
        $menuFooters = $this->menuService->getFooter();

        $view->with('menuFooters', $menuFooters);
    }
}