<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\Menu;
use App\SubMenu;
use App\Article;

use Request;
use Crypt;

class MenuController extends Controller
{
    public function index() {
        return view('menu.menu-list')->with([
            'pageTitle' => 'Manage Menu', 
            'title' => 'List Menu', 
            'sidebar' => 'menu'
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
        
        $menu = new SubMenu;
        
        if ($dataSend['search']){
            $menu = $menu->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $menu->count();

        $list = $menu->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

        if ($dataSend["order"]) {
            $list = $list->orderBy($dataSend["order"], $dataSend["sort"])->get()->toArray();
        } else {
            $list = $list->orderBy('created_at', $dataSend["sort"])->get()->toArray();
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
        $menuAll = Menu::all()->toArray();
        return view('menu.menu-add')->with([
            'pageTitle' => 'Manage Menu', 
            'title' => 'Add Menu', 
            'sidebar' => 'menu',
            'menu' => $menuAll
        ]);
    }

    public function store() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        if (!(isset($data['child']) && $data['child'] == 1)) {
            $menuInsert = new Menu;
            $menuInsert->name = $data['title'];
            $menuInsert->save();
            
            $menuId = $menuInsert->id;
        } else {
            $menuId = $data['menu_id'];
        }

        $insert = new SubMenu;
        $str = strtolower($data['title']);
        $insert->slug = preg_replace('/\s+/', '-', $str);
        $insert->name = $data['title'];
        if (isset($data['child']) && $data['child'] == 1) {
            $insert->is_child = $data['child'];
        }
        $insert->menu_id = $menuId;
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save menu!',
                'url' => 'close'
            ];
            return redirect('/menu')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save menu',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);

        $sub_menu = SubMenu::where('id', $id)->first()->toArray();
        $menuAll = Menu::all()->toArray();

        return view('menu.menu-edit')->with([
            'pageTitle' => 'Manage Menu', 
            'title' => 'Edit Menu', 
            'sidebar' => 'menu',
            'menu' => $menuAll,
            'detail' =>$sub_menu
        ]);
    }

    public function update() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $update = SubMenu::where('id', $data['id'])->first();
        if ($update->is_child == 0) {
            $menuUpdate =  Menu::where('id', $update->menu_id)->first();
            $menuUpdate->name = $data['title'];
        }
        $str = strtolower($data['title']);
        $update->slug = preg_replace('/\s+/', '-', $str);
        $update->name = $data['title'];
        $update->save();

        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success edit menu!',
                'url' => 'close'
            ];

            return redirect('/menu')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error edit menu',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $sub_menu = SubMenu::where('id', $id)->first()->toArray();
        $deleteArticle = Article::where('sub_menu_id', $sub_menu['id'])->delete();
        if ($sub_menu['is_child'] == 0) {
            $delete = SubMenu::where('menu_id', $sub_menu['menu_id'])->delete();
        } else {
            $delete = SubMenu::where('id', $id)->delete();
        }
        $menu = Menu::where('id', $sub_menu['menu_id'])->delete();
        
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete menu!',
                'url' => 'close'
            ];

            return redirect('/menu')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete menu',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
