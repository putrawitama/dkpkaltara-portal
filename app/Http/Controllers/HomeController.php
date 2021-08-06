<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Article;
use App\Gallery;


class HomeController extends Controller
{
    public function index() {
        if (Session()->get('session_id') != null) {
            $menu = Menu::count();
            $article = Article::count();
            $gallery = Gallery::count();
            return view('welcome')->with([
                'pageTitle' => 'Dashboard', 
                'title' => 'Dashboard', 
                'sidebar' => 'dashboard',
                'menu' => $menu,
                'article' => $article,
                'gallery' => $gallery
            ]);
        } else {
            return view('login');
        }
    }
}
