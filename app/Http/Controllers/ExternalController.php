<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\External;

use Request;
use Crypt;

class ExternalController extends Controller
{
    public function index() {
        return view('external.external-list')->with([
            'pageTitle' => 'Manage External Link', 
            'title' => 'List External', 
            'sidebar' => 'external'
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
        
        $external = new external;
        
        if ($dataSend['search']){
            $external = $external->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $external->count();

        $list = $external->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

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

        return view('external.external-add')->with([
            'pageTitle' => 'Manage External Link', 
            'title' => 'Add External Link', 
            'sidebar' => 'external',
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
                $path_path = $image[$i]->storeAs('uploads', 'image_external_'.time().$i.'.'.$ext, 'public');

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

        $insert = new External;
        $insert->title = $data['title'];
        $insert->link = $data['link'];
        $insert->image = json_encode($path);
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save external link!',
                'url' => 'close'
            ];

            return redirect('/external')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save external link',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);

        $detail = External::where('id', $id)->first()->toArray();
        $detail['images'] = json_decode($detail['image']);

        return view('external.external-edit')->with([
            'pageTitle' => 'Manage External', 
            'title' => 'Edit External', 
            'sidebar' => 'external',
            'detail' => $detail,
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
                $path_path = $value->storeAs('uploads', 'image_external_'.time().$key.'.'.$ext, 'public');

                $path[$key] = $path_path;
            }
        }

        $update = External::where('id', $data['id'])->first();
        $update->title = $data['title'];
        $update->link = $data['link'];
        $update->image = json_encode(array_values($path));
        $update->save();

        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success edit external!',
                'url' => 'close'
            ];

            return redirect('/external')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error edit external',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $delete = External::where('id', $id)->delete();
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete external!',
                'url' => 'close'
            ];

            return redirect('/external')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete external',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
