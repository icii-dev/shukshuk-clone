<?php

namespace App\Http\Controllers\Buyer;

use App\Model\Menu;
use App\Model\Page;
use App\Http\Controllers\Controller;
use App\Model\MenuItem;

class AboutController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $footerMenuId = Menu::where('name', 'footer')->firstOrFail()->id;
        $category = MenuItem::where('url', $slug)->where('menu_id', $footerMenuId)->firstOrFail();
        $page = $category->page;
        if (!$page)
        {
//            abort(404);
            $page = Page::first();
        }

        $this->seo()->setTitle($page->seo_title ?? $page->title);
        $this->seo()->setDescription($page->meta_description ?? $page->excerpt);

        return view('buyer.about')->with([
            'page' => $page,
            'category' => $category,
        ]);
    }
}
