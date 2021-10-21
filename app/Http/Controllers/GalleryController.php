<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\Gallery;

use Request;
use Crypt;

class GalleryController extends Controller
{
    public function index() {
        return view('gallery.gallery-list')->with([
            'pageTitle' => 'Manage Gallery', 
            'title' => 'List Gallery', 
            'sidebar' => 'gallery'
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
        
        $gallery = new Gallery;
        
        if ($dataSend['search']){
            $gallery = $gallery->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $gallery->count();

        $list = $gallery->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

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
        return view('gallery.gallery-add')->with([
            'pageTitle' => 'Manage Gallery', 
            'title' => 'Add Gallery', 
            'sidebar' => 'gallery'
        ]);
    }

    public function store() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $path = [];
        if (isset($data['isVideo']) && $data['isVideo'] == 1) {
            if (Request::has('video')) {
                $video = Request::file('video');
                
                for ($i=0; $i < count($video); $i++) {
                    $ext = $video[$i]->getClientOriginalExtension();
                    $path_path = $video[$i]->storeAs('uploads', 'video_gallery_'.time().$i.'.'.$ext, 'public');
    
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
        } else {
            if (Request::has('image')) {
                $image = Request::file('image');
                
                for ($i=0; $i < count($image); $i++) {
                    $ext = $image[$i]->getClientOriginalExtension();
                    $path_path = $image[$i]->storeAs('uploads', 'image_gallery_'.time().$i.'.'.$ext, 'public');
    
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
        }

        $insert = new Gallery;
        $insert->title = $data['title'];
        $insert->desc = $data['desc'];
        if (isset($data['publish']) && $data['publish'] == 1) {
            $insert->publish = $data['publish'];
        }
        if (isset($data['isVideo']) && $data['isVideo'] == 1) {
            $insert->type = $data['isVideo'];
        }
        $insert->images = json_encode($path);
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function edit($id) {
        $id = Crypt::decryptString($id);

        $detail = Gallery::where('id', $id)->first()->toArray();
        $detail['images'] = json_decode($detail['images']);

        return view('gallery.gallery-edit')->with([
            'pageTitle' => 'Manage Gallery', 
            'title' => 'Edit Gallery', 
            'sidebar' => 'gallery',
            'detail' => $detail
        ]);
    }

    public function update() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);

        $path = [];
        if (Request::has('video')) {
            $video = Request::file('video');
            
            for ($i=0; $i < count($video); $i++) {
                $ext = $video[$i]->getClientOriginalExtension();
                $path_path = $video[$i]->storeAs('uploads', 'video_gallery_'.time().$i.'.'.$ext, 'public');

                array_push($path, $path_path);
            }
        } else {
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
                    $path_path = $value->storeAs('uploads', 'image_gallery_'.time().$key.'.'.$ext, 'public');
    
                    $path[$key] = $path_path;
                }
            }
        }

        $update = Gallery::where('id', $data['id'])->first();
        $update->title = $data['title'];
        $update->desc = $data['desc'];
        if (isset($data['publish']) && $data['publish'] == 1) {
            $update->publish = $data['publish'];
        }
        $update->images = json_encode(array_values($path));
        $update->save();

        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success edit gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error edit gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function publish($id) {
        $id = Crypt::decryptString($id);

        $update = Gallery::where('id', $id)->first();
        $update->publish = 1;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success publish gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error publish gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function unpublish($id) {
        $id = Crypt::decryptString($id);

        $update = Gallery::where('id', $id)->first();
        $update->publish = 0;
        $update->save();
        
        if ($update->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success unpublish gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error unpublish gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }

    public function delete($id) {
        $id = Crypt::decryptString($id);

        $delete = Gallery::where('id', $id)->delete();
        
        if ($delete) {
            $messages = [
                'status' => 'success',
                'message' => 'Success delete gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error delete gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
