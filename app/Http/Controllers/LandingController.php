<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;

use Request;
use Crypt;
use App\Article;
use App\Menu;
use App\SubMenu;
use App\Gallery;
use App\External;
use App\Adsense;
use Http;

class LandingController extends Controller
{
    //

    public function home()
    {
        $response = Http::get('https://www.instagram.com/dkp.kaltara/?__a=1');
        $data = $response->json();

        $latestPost = $data["graphql"]["user"]["edge_owner_to_timeline_media"]["edges"][0]["node"]["shortcode"];
        $menu = Menu::with('subMenu')->get();
        $link = External::all();
        $article = Article::where('publish', 1)->with('subMenu')->latest()->take(10)->get();
        $ads = Adsense::where('publish', 1)->first();
        return view('landing.landing')->with([
            'navbar' => 'home',
            'menu' => $menu,
            'article' => $article,
            'link' => $link,
            'ads' => $ads,
            'latestIg' => 'CSax6m3nHd9'
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

    public function detailGallery($type, $id = null)
    {

        if (!($type === 'video' || $type === 'photo')) {
            abort(404);
        }

        $menus = Menu::with('subMenu')->get();
        $data = [
            'menu'=> $menus,
            'type' => $type,
            'is_detail' => $id === null ? false : true
        ];

        if ($id === null) {
            if ($type === 'video') {
                $galleries = Gallery::where('type', 1)->where('publish', 1)->latest()->get();
            } else {
                $galleries = Gallery::where('type', 0)->where('publish', 1)->latest()->get();
            }

            $data['list'] = $galleries;
        } else {
            $gallery = Gallery::where('id', $id)->where('publish', 1)->first();

            if ($gallery === null) {
                abort(404);
            }
            $data['detail'] = $gallery;
        }

        return view('landing.gallery')->with($data);
    }

    public function contactUs()
    {
        $menu = Menu::with('subMenu')->get();
        return view('landing.contact')->with([
            'menu' => $menu
        ]);
    }

    public function postContact()
    {

        $data = Request::all();

        $details = [
            'subject' => $data['subject'],
            'content' => $data['message'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];
       
        \Mail::to('dkp@kaltaraprov.go.id')->send(new \App\Mail\ContactMail($details));

        return redirect('/kontak')->with('notif', 'Pesan Telah Terkirim');
    }


}
