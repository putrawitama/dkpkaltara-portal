<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\Article;
use App\Menu;
use App\SubMenu;

use Request;
use Crypt;

class ArticleController extends Controller
{
    public function index() {
        return view('article.article-list')->with([
            'pageTitle' => 'Manage Article', 
            'title' => 'List Article', 
            'sidebar' => 'article'
        ]);
    }

    public function list() {
        $dataSend = array(
            "search" => Request::input('search')['value'],
            "offset" => Request::input('start'),
            "limit" => Request::input('length'),
            'order' => (!empty(Request::get('columns')[Request::get('order')[0]['column']]['data'])) ? Request::get('columns')[Request::get('order')[0]['column']]['data'] : '',
            'sort' => (!empty(Request::get('order')[0]['dir'])) ? Request::get('order')[0]['dir'] : '',
        );
        
        $article = new Article;
        
        if ($dataSend['search']){
            $article = $article->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $article->count();

        $list = $article->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

        if ($dataSend["order"]) {
            $list = $list->orderBy($dataSend["order"], $dataSend["sort"])->with('subMenu')->get()->toArray();
        } else {
            $list = $list->orderBy('created_at', $dataSend["sort"])->with('subMenu')->get()->toArray();
        }

        for ($i=0; $i < count($list); $i++) { 
            $list[$i]['link_id'] = Crypt::encryptString($list[$i]['id']);
        }

        if ($list != null) {
            $response = array(
                "draw"              => Request::get('draw'),
                "recordsTotal"      => $count,
                "recordsFiltered"   => $count,
                "data"              => $list
            );
        }else{
            $response = array(
                "draw"              => Request::get('draw'),
                "recordsTotal"      => 0,
                "recordsFiltered"   => 0,
                "data"              => []
            );
        }

        return $response;
    }

    public function add() {

        $menu = SubMenu::all()->toArray();
        return view('article.article-add')->with([
            'pageTitle' => 'Manage Article', 
            'title' => 'Add Article', 
            'sidebar' => 'article',
            'menu' => $menu
        ]);
    }

    public function store() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $path = [];
        if (Request::has('image')) {
            $image = Request::file('image');
            
            for ($i=0; $i < count($image); $i++) {
                $ext = $image[$i]->getClientOriginalExtension();
                $path_path = $image[$i]->storeAs('uploads', 'image_article_'.time().$i.'.'.$ext, 'public');

                array_push($path, $path_path);
            }
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Input images require',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }

        $insert = new Article;
        $str = strtolower($data['title']);
        $insert->slug = preg_replace('/\s+/', '-', $str);
        $insert->title = $data['title'];
        $insert->description = $data['desc'];
        if (isset($data['publish']) && $data['publish'] == 1) {
            $insert->publish = $data['publish'];
        }
        $insert->thumbnail = json_encode($path);
        $insert->user_id = 1;
        $insert->sub_menu_id = $data['sub_menu'];
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save article!',
                'url' => 'close'
            ];

            return redirect('/article')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save article',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);

        $detail = Article::where('id', $id)->first()->toArray();
        $detail['images'] = json_decode($detail['thumbnail']);
        $menu = SubMenu::all()->toArray();

        return view('article.article-edit')->with([
            'pageTitle' => 'Manage Article', 
            'title' => 'Edit Article', 
            'sidebar' => 'article',
            'detail' => $detail,
            'menu' => $menu
        ]);
    }

    public function update() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $path = [];
        if (isset($data['imgReview'])) {
            if (!is_array($data['imgReview'])) {
                $path[0] = $data['imgReview'];
            } else {
                $path = array_merge($path, $data['imgReview']);
            }
        }

        if (Request::has('image')) {
            $image = Request::file('image');

            foreach ($image as $key => $value) {
                unset($path[$key]);
                $ext = $value->getClientOriginalExtension();
                $path_path = $value->storeAs('uploads', 'image_article_'.time().$key.'.'.$ext, 'public');

                $path[$key] = $path_path;
            }
        }

        $update = Article::where('id', $data['id'])->first();
        $str = strtolower($data['title']);
        $update->slug = preg_replace('/\s+/', '-', $str);
        $update->title = $data['title'];
        $update->description = $data['desc'];
        if (isset($data['publish']) && $data['publish'] == 1) {
            $update->publish = $data['publish'];
        }
        $update->thumbnail = json_encode(array_values($path));
        $update->user_id = 1;
        $update->sub_menu_id = $data['sub_menu'];
        $update->save();

        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success edit article!',
                'url' => 'close'
            ];

            return redirect('/article')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error edit article',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function publish($id) {
        $id = Crypt::decryptString($id);

        $update = Article::where('id', $id)->first();
        $update->publish = 1;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success publish article!',
                'url' => 'close'
            ];

            return redirect('/article')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error publish article',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function unpublish($id) {
        $id = Crypt::decryptString($id);

        $update = Article::where('id', $id)->first();
        $update->publish = 0;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success unpublish article!',
                'url' => 'close'
            ];

            return redirect('/article')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error unpublish article',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $delete = Article::where('id', $id)->delete();
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete article!',
                'url' => 'close'
            ];

            return redirect('/article')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete article',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
