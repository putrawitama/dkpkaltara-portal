<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\User;

use Request;
use Crypt;
use Hash;

class UserController extends Controller
{
    public function index() {
        return view('user.user-list')->with([
            'pageTitle' => 'Manage User', 
            'title' => 'List User', 
            'sidebar' => 'user'
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
        
        $menu = new User;
        
        if ($dataSend['search']){
            $menu = $menu->where('name','like','%'.$dataSend['search'].'%');
        }
        $count = $menu->count();

        $list = $menu->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

        if ($dataSend["order"]) {
            $list = $list->orderBy($dataSend["order"], $dataSend["sort"])->get()->toArray();
        } else {
            $list = $list->orderBy('created_at', $dataSend["sort"])->get()->toArray();
        }

        for ($i=0; $i < count($list); $i++) { 
            if (session('session_id.email') == $list[$i]['email']) {
                $list[$i]['is_user'] = true;
            } else {
                $list[$i]['is_user'] = false;
            }

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
        return view('user.user-add')->with([
            'pageTitle' => 'Manage User', 
            'title' => 'Add User', 
            'sidebar' => 'user',
        ]);
    }

    public function store() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $isExist = User::where('email', $data['email'])->get()->toArray();
        if (!empty($isExist)) {
            return [
                'status'  => 'error',
                'message' => 'Email already exist'
            ];
        }

        $insert = new User;
        $insert->name = $data['name'];
        $insert->email = $data['email'];
        $insert->user_type = $data['user_type'];
        $insert->password = Hash::make($data['password'].env('SALT_PASS'));
        $insert->save();

        if ($insert->save()) {
            return [
                'status'   => 'success',
                'message' => 'Success add user!',
                'url'      => '/user',
                'callback' => 'redirect'
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => 'Error add user'
            ];
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);
        $detail = User::where('id', $id)->first()->toArray();

        return view('user.user-edit')->with([
            'pageTitle' => 'Manage User', 
            'title' => 'Edit User', 
            'sidebar' => 'user',
            'detail' => $detail
        ]);
    }

    public function update() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $isExist = User::where('email', $data['email'])->whereNotIn('id', [$data['id']])->get()->toArray();
        if (!empty($isExist)) {
            return [
                'status'  => 'error',
                'message' => 'Email already exist'
            ];
        }

        $update = User::where('id', $data['id'])->first();
        $update->name = $data['name'];
        $update->email = $data['email'];
        $update->user_type = $data['user_type'];
        if (isset($data['password'])) {
            $update->password = Hash::make($data['password'].env('SALT_PASS'));
        }
        $update->save();

        if ($update->save()) {
            return [
                'status'   => 'success',
                'message' => 'Success edit user!',
                'url'      => '/user',
                'callback' => 'redirect'
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => 'Error edit user'
            ];
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $delete = User::where('id', $id)->delete();
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete user!',
                'url' => 'close'
            ];

            return redirect('/user')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete user',
                'url' => 'close',
            ];

            return back()->with('notif', $messages);
        }
    }
}
