<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Menu;
use App\SubMenu;
use App\Gallery;

class LandingController extends Controller
{
    //

    public function home()
    {
        $menu = Menu::with('subMenu')->get();
        $article = Article::where('publish', 1)->with('subMenu')->latest()->take(10)->get();
        return view('landing.landing')->with([
            'navbar' => 'home',
            'menu' => $menu,
            'article' => $article
        ]);
    }

    public function listArticleByMenu($menu, $article = null)
    {
        # code...
        $menus = Menu::with('subMenu')->get();
        $detailMenu = SubMenu::where('slug', $menu)->first();
        if ($detailMenu == null) {
            abort(404);
        }
        
        $data = [
            'navbar' => $detailMenu->name,
            'menu' => $menus,
            'is_detail' => $article == null ? false : true
        ];

        if ($article == null) {
            $articles = Article::where('publish', 1)
                                ->where('sub_menu_id', $detailMenu->id)
                                ->with('subMenu')
                                ->latest()->get();
            $data['list'] = $articles;
        } else {
            $detailArticle = Article::where('slug', $article)
                                    ->where('sub_menu_id', $detailMenu->id)
                                    ->with('subMenu')
                                    ->first();
            if ($detailArticle == null) {
                abort(404);
            }

            $data['detail'] = $detailArticle;
        }

        return view('landing.list')->with($data);
    }

    public function listGallery()
    {
        # code...
    }

    public function detailGallery($id)
    {
        # code...
    }


}
