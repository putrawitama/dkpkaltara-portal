<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\Adsense;

use Request;
use Crypt;

class AdsenseController extends Controller
{
    public function index() {
        return view('adsense.adsense-list')->with([
            'pageTitle' => 'Manage Adsense Link', 
            'title' => 'List Adsense', 
            'sidebar' => 'adsense'
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
        
        $adsense = new adsense;
        
        if ($dataSend['search']){
            $adsense = $adsense->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $adsense->count();

        $list = $adsense->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

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

        return view('adsense.adsense-add')->with([
            'pageTitle' => 'Manage Adsense Link', 
            'title' => 'Add Adsense Link', 
            'sidebar' => 'adsense',
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
                $path_path = $image[$i]->storeAs('uploads', 'image_adsense_'.time().$i.'.'.$ext, 'public');

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

        $insert = new Adsense;
        if (isset($data['publish']) && $data['publish'] == 1) {
            $off = Adsense::where('publish', 1)->update(['publish' => 0]);
            $insert->publish = $data['publish'];
        }
        $insert->title = $data['title'];
        $insert->link = $data['link'];
        $insert->image = json_encode($path);
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save adsense link!',
                'url' => 'close'
            ];

            return redirect('/adsense')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save adsense link',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);

        $detail = Adsense::where('id', $id)->first()->toArray();
        $detail['images'] = json_decode($detail['image']);

        return view('adsense.adsense-edit')->with([
            'pageTitle' => 'Manage Adsense', 
            'title' => 'Edit Adsense', 
            'sidebar' => 'adsense',
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
                $path_path = $value->storeAs('uploads', 'image_adsense_'.time().$key.'.'.$ext, 'public');

                $path[$key] = $path_path;
            }
        }

        $update = Adsense::where('id', $data['id'])->first();
        if (isset($data['publish']) && $data['publish'] == 1) {
            $off = Adsense::where('publish', 1)->update(['publish' => 0]);
            $update->publish = $data['publish'];
        } else {
            $update->publish = 0;
        }
        $update->title = $data['title'];
        $update->link = $data['link'];
        $update->image = json_encode(array_values($path));
        $update->save();

        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success edit adsense!',
                'url' => 'close'
            ];

            return redirect('/adsense')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error edit adsense',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $delete = Adsense::where('id', $id)->delete();
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete adsense!',
                'url' => 'close'
            ];

            return redirect('/adsense')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete adsense',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function publish($id) {
        $id = Crypt::decryptString($id);

        $off = Adsense::where('publish', 1)->update(['publish' => 0]);

        $update = Adsense::where('id', $id)->first();
        $update->publish = 1;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success publish adsense!',
                'url' => 'close'
            ];

            return redirect('/adsense')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error publish adsense',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function unpublish($id) {
        $id = Crypt::decryptString($id);

        $update = Adsense::where('id', $id)->first();
        $update->publish = 0;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success unpublish adsense!',
                'url' => 'close'
            ];

            return redirect('/adsense')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error unpublish adsense',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
